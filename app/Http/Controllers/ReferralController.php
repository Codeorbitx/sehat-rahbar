<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Referral;

class ReferralController extends Controller
{
    public function create(Patient $patient)
    {
        return view('referrals.create', compact('patient'));
    }

    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'facility_name' => 'required|string|max:255',
            'referral_date' => 'required|date',
        ]);

        $triageResult = $patient->screenings()->latest()->first()?->triageResult;

        if (! $triageResult) {
            return redirect()->route('patients.show', $patient)
                ->with('error', 'No screening result available to link the referral.');
        }

        Referral::create([
            'patient_id' => $patient->id,
            'triage_result_id' => $triageResult->id,
            'facility_name' => $validated['facility_name'],
            'referral_date' => $validated['referral_date'],
            'status' => 'pending',
        ]);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Referral created successfully.');
    }
}
