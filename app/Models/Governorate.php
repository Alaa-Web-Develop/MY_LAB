<?php

namespace App\Models;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Governorate extends Model
{
    use HasFactory;
    protected $fillable=[
        'governorate_name_ar', 'governorate_name_en', 'is_active'
    ];
    public function cities(){
        return $this->hasMany(City::class,'governorate_id');
    }


    public function lab(){
        return $this->hasMany(Lab::class);
    }


    public function branch(){
        return $this->hasMany(LabBranch::class);
    }

    
}
