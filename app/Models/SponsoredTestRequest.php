<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Sponser;
use App\Models\LabOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SponsoredTestRequest extends Model
{
    use HasFactory;
    protected $fillable=[
        'doctor_id', 'patient_id', 'lab_order_id', 'status','sponser_id'
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }
    public function labOrder(){
        return $this->belongsTo(LabOrder::class,'lab_order_id');
    }
    public function sponsor(){
        return $this->belongsTo(Sponser::class,'sponser_id');
    }
}
