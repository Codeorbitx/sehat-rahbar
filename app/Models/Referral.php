<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = ['patient_id', 'triage_result_id', 'facility_name', 'status', 'referral_date'];

public function patient()
{
    return $this->belongsTo(Patient::class);
}
}
