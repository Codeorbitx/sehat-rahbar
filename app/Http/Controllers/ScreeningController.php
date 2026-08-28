<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        TriageResult::create([
            'screening_id' => $screening->id,
            'priority_level' => $priority,
            'reasons' => $reasons,
        ]);

        return redirect()->route('patients.create')->with('success', "Screening saved. Priority: {$priority}");
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