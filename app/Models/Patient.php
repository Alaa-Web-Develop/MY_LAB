<?php

namespace App\Models;

use App\Models\CourierCollectedTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
  use HasFactory,Notifiable;
  protected $fillable = [
    'firstname', 'lastname', 'doctor_id', 'pathology_report_image', 'phone', 'email', 'age', 'comment', 'diagnose_id','tracking_number'
  ];

  //local scope
  public function scopeFilter(Builder $builder, $filters)
  {
    $options = array_merge([
      'firstname' => null,
      'lastname' => null,
      'phone' => null,
      'id' => null
    ], $filters);

    $builder->when($options['firstname'], function ($builder, $value) {
      $builder->where('firstname', $value);
    });

    $builder->when($options['lastname'], function ($builder, $value) {
      $builder->where('lastname', $value);
    });

    $builder->when($options['phone'], function ($builder, $value) {
      $builder->where('phone', $value);
    });

    $builder->when($options['id'], function ($builder, $value) {
      $builder->where('id', $value);
    });


  }
  //Rel


  public function doctor()
  {
    return $this->belongsTo(Doctor::class, 'doctor_id')->withDefault();
  }

  public function labOrders()
  {
    return $this->hasMany(LabOrder::class);
  }

  public function cases()
  {
    return $this->hasMany(PatientCase::class);
  }

  public function diagnose()
  {
      return $this->belongsTo(Diagnose::class);
  }

  // Accessors
  public function getFullNameAttribute()
  {
      return $this->firstname . ' ' . $this->lastname;
  }

  public function getDoctorNameAttribute()
  {
      return $this->doctor->name ?? '';
  }

  public function getTumorNameAttribute()
  {
      return $this->tumor->name ?? '';
  }

  // Append full name, doctor name, and tumor name to API responses
  protected $appends = ['full_name', 'doctor_name'];

}
