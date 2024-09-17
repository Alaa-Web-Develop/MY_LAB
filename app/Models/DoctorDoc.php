<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDoc extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id', 'docs', 
    ];

    //Relatioin:

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    //Accessors
    public function getImageUrlAttribute()
    {
        if($this->docs)
        {
            return asset($this->docs);
        }
         
    }

    //appends api response
    protected $appends=['image_url']; 
}
