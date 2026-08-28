<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TriageResult extends Model
{
    protected $fillable = ['screening_id', 'priority_level', 'reasons'];

public function screening()
{
    return $this->belongsTo(Screening::class);
}
}
