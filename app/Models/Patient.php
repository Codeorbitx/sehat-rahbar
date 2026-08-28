<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'age', 'gestational_age_weeks', 'contact_number', 'registered_by'];

public function screenings()
{
    return $this->hasMany(Screening::class);
}

public function referrals()
{
    return $this->hasMany(Referral::class);
}
}
