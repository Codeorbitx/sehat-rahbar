<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use App\Models\Patient;
use App\Models\Screening;
use App\Models\TriageResult;

class ScreeningController extends Controller
{
    public function create(Patient $patient)
    {
        return view('screenings.create', compact('patient'));
    }

    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'bp_systolic' => 'nullable|integer',
            'bp_diastolic' => 'nullable|integer',
            'blood_sugar' => 'nullable|numeric',
            'body_temp' => 'nullable|numeric',
            'heart_rate' => 'nullable|integer',
            'swelling' => 'boolean',
            'severe_headache' => 'boolean',
            'vision_issues' => 'boolean',
            'low_fetal_movement' => 'boolean',
            'other_symptoms' => 'nullable|string',
        ]);

        $validated['patient_id'] = $patient->id;
        $validated['lhw_id'] = auth()->id();

        $screening = Screening::create($validated);

        [$priority, $reasons] = $this->calculateTriage($validated);

        $triageResult = TriageResult::create([
            'screening_id' => $screening->id,
            'priority_level' => $priority,
            'reasons' => $reasons,
        ]);

        $this->attachMlPrediction($triageResult, $patient, $validated);

        return redirect()->route('screenings.result', $screening->id);
    }
    public function result(Screening $screening)
{
    $screening->load('patient', 'triageResult');
    return view('screenings.result', compact('screening'));
}

    /**
     * Attach the ML risk prediction to the triage result as a supporting signal.
     * Skips silently (leaving ml_risk_level null) when any input is missing or
     * the ML service is unreachable, so the screening save is never affected.
     */
    private function attachMlPrediction(TriageResult $triageResult, Patient $patient, array $data): void
    {
        $features = [
            'age' => $patient->age,
            'systolic_bp' => $data['bp_systolic'] ?? null,
            'diastolic_bp' => $data['bp_diastolic'] ?? null,
            'blood_sugar' => $data['blood_sugar'] ?? null,
            'body_temp' => $data['body_temp'] ?? null,
            'heart_rate' => $data['heart_rate'] ?? null,
        ];

        if (in_array(null, $features, true)) {
            return;
        }

        try {
            $response = Http::timeout(5)->post(config('services.ml_api_url') . '/predict', $features);
        } catch (ConnectionException) {
            return;
        }

        if (! $response->successful()) {
            return;
        }

        $riskLevel = $response->json('risk_level');

        if ($riskLevel === null) {
            return;
        }

        $triageResult->update([
            'ml_risk_level' => $riskLevel,
            'ml_confidence' => $response->json('confidence'),
        ]);
    }
    private function calculateTriage($data)
    {
        $reasons = [];
        $priority = 'low';

        $systolic = $data['bp_systolic'] ?? null;
        $diastolic = $data['bp_diastolic'] ?? null;

        if ($systolic >= 160 || $diastolic >= 110) {
            $priority = 'high';
            $reasons[] = 'Severe hypertension (BP >= 160/110)';
        } elseif ($systolic >= 140 || $diastolic >= 90) {
            $priority = 'moderate';
            $reasons[] = 'Elevated BP (>= 140/90)';
        }

        if (!empty($data['severe_headache']) && !empty($data['vision_issues'])) {
            $priority = 'high';
            $reasons[] = 'Severe headache with visual disturbance';
        }

        if (!empty($data['low_fetal_movement'])) {
            $priority = 'high';
            $reasons[] = 'Reduced fetal movement reported';
        }

        if (!empty($data['swelling']) && $priority === 'low') {
            $priority = 'moderate';
            $reasons[] = 'Swelling reported';
        }

        if (empty($reasons)) {
            $reasons[] = 'No concerning signs reported';
        }

        return [$priority, implode('; ', $reasons)];
    }
}