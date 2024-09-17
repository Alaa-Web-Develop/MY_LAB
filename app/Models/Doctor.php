<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'Approval_Status',
        'speciality_id',
        'institution_id',
        'governorate_id',
        'city_id',
        'doctor_notes',
        'user_id',
        'random_number',
        'total_points',
        'source',

    ];

    //Relations
    public function doctorDocs()
    {
        return $this->hasMany(DoctorDoc::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id', 'id')->withDefault();
    }
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id', 'id')->withDefault();
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id', 'id')->withDefault();
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id')->withDefault();
    }

    public function pointsTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function pointsTransferRequests()
    {
        return $this->hasMany(PointTranferRrequest::class);
    }

    public function labOrders()
    {
        return $this->hasMany(LabOrder::class);
    }

    //hide props in api response
    protected $hidden = [
        'user_id',
        'Approval_Status',
        'created_at',
        'updated_at',
        'doctor_notes',
        'speciality_id',
        'institution_id',
        'governorate_id',
        'city_id'
    ];
}
