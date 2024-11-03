<?php

namespace App\Models;

use App\Models\Test;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnose extends Model
{
    use HasFactory;
    protected $fillable=[
'name','status'
    ];

    public function tests(){
        return $this->hasMany(Test::class,'diagnose_id');
    }


    public function patients(){
        return $this->hasMany(Patient::class,'diagnose_id');
    }

}
