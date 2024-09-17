<?php

namespace App\Models;

use App\Models\SponserTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lab extends Model
{
    use HasFactory;
    protected $fillable=['name','logo','phone','hotline','email','Approval_Status','governorate_id','city_id','address','location','description'];

    //Rel
    public function branches()
    {
        return $this->hasMany(LabBranch::class);
    }

    public function labOrders()
    {
        return $this->hasMany(LabOrder::class);
    }
    public function sponsor()
    {
        return $this->hasMany(SponserTest::class,'lab_id');
    }
    public function tests()
    {
        return $this->belongsToMany(Test::class,'lab_tests')->withPivot(['price', 'points', 'notes','discount_points']);
    }
   
}


