<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCase extends Model
{
    use HasFactory;
    protected $fillable=[
       'patient_id','doctor_id', 'pathology_report_image', 'diagnose_id', 'comment'
    ]; 

    //Relation
    public function patient()
  {
    return $this->belongsTo(Patient::class)->withDefault();
  }

  public function labOrders()
  {
    return $this->hasMany(LabOrder::class);
  }

  public function diagnose()
  {
    return $this->belongsTo(Diagnose::class);
  }

  //Accessors diagnose_id patient-id lab_branche_id

  public function getDiagnoseNameAttribute()
  {
    $name=Diagnose::where('id','=',$this->diagnose_id)->first()->name;
    return $name;
  }
  public function getPatientNameAttribute()
  {
    $name=Patient::where('id','=',$this->patient_id)->first();
    return $name->full_name;
  }
  public function getDoctorNameAttribute()
  {
    $name=Doctor::where('id','=',$this->doctor_id)->first()->name;
    return $name;
  }


  //Api appends
  // protected $appends=['patient_name','doctor_name'];

  // protected $hidden=['patient_id','doctor_id'];
}
