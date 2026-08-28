<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientController extends Controller
{
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

    \App\Models\Patient::create($validated);

    return redirect()->route('patients.create')->with('success', 'Patient registered successfully.');
}
}
