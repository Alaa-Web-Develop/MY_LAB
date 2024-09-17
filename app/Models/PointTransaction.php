<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    use HasFactory;
    protected $fillable=['doctor_id', 
    'patient_id', 
    'points', 
    'type'];

    //rel
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected $casts = [
        'points' => 'integer',
    ];
}
