<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TriageResult extends Model
{
    protected $fillable = ['screening_id', 'priority_level', 'reasons', 'ml_risk_level', 'ml_confidence'];

public function screening()
{
    return $this->belongsTo(Screening::class);
}

public function referrals()
{
    return $this->hasMany(Referral::class);
}
}
