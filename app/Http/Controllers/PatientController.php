<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = \App\Models\Patient::latest()->get();

        return view('patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'screenings' => fn ($query) => $query->latest()->with('triageResult'),
            'referrals' => fn ($query) => $query->latest('referral_date'),
        ]);

        return view('patients.show', compact('patient'));
    }

    public function create()
{
    return view('patients.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'nullable|integer',
        'gestational_age_weeks' => 'nullable|integer',
        'contact_number' => 'nullable|string|max:20',
    ]);

    $validated['registered_by'] = auth()->id();

    $patient = Patient::create($validated);

    $patient->update([
        'patient_code' => sprintf(
            'SR-%s-%04d',
            now()->year,
            Patient::whereYear('created_at', now()->year)->count()
        ),
    ]);

    return redirect()->route('patients.create')->with('success', 'Patient registered successfully.');
}
}
