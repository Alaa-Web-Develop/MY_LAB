<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabOrder extends Model
{
    use HasFactory;
    protected $fillable=[
        'patient_id', 'doctor_id', 'test_id', 'lab_branche_id','patient_case_id','lab_id','discount_points','has_courier','courier_id'
    ];

    //Rel
    public function patient()
    {
        return $this->belongsTo(Patient::class)->withDefault();
    }

      public function courier()
    {
        return $this->belongsTo(Courier::class,'courier_id');
    }

    public function patient_case()
    {
        return $this->belongsTo(PatientCase::class)->withDefault();
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    
    public function labTrack()
    {
        return $this->hasOne(TrackLabTest::class);
    }

    public function labBranch()
    {
        return $this->belongsTo(LabBranch::class, 'lab_branche_id');
    }

    public function labTest()
    {
        return $this->belongsTo(Lab_Branch_Test::class, 'test_id', 'test_id');
    }



    public function test()
    {
        return $this->belongsTo(Test::class,'test_id');
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class,'test_id');
    }







    //Accessors===================================
    public function getPatientNameAttribute()
    {
        return Patient::where('id','=',$this->patient_id)->first()->name;
    }

    public function getDoctorNameAttribute()
    {
        return Doctor::where('id','=',$this->doctor_id)->first()->name;
    }
    public function getLabBranchNameAttribute()
    {
        return LabBranch::where('id','=',$this->lab_branche_id)->first()->name;
    }

    public function getLabBranchIdAttribute()
    {
        return LabBranch::where('id','=',$this->lab_branche_id)->first()->id;
    }

    // 'patient_id', 'doctor_id', 'test_id', 'lab_branche_id','patient_case_id'
    //Appends apis  'test_name',
    //protected $appends=['patient_name','doctor_name','lab_branch_name','lab_branch_id'];
}
