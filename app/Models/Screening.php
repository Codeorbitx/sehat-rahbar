<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    protected $fillable = ['patient_id', 'lhw_id', 'bp_systolic', 'bp_diastolic', 'glucose_level', 'hemoglobin_level', 'swelling', 'severe_headache', 'vision_issues', 'low_fetal_movement', 'other_symptoms'];

public function patient()
{
    return $this->belongsTo(Patient::class);
}

public function triageResult()
{
    return $this->hasOne(TriageResult::class);
}
}
