<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabBranch extends Model
{
    use HasFactory;

    protected $fillable=['name','lab_id','phone','hotline','email','Approval_Status','governorate_id','city_id','location','description','user_id'];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

       public function govern(){
        return $this->belongsTo(Governorate::class,'governorate_id');
       }

    public function tests()
    {
        return $this->belongsToMany(Test::class,'lab_branche_test')->withPivot(['price', 'points', 'notes']);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }

    public function labOrder()
    {
        return $this->belongsTo(LabOrder::class)->withDefault();
    }

}
