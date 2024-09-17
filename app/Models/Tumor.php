<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tumor extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','status'
            ];

            //Rel
            public function tests()
            {
                return $this->hasMany(Test::class);
            }
}
