<?php

namespace App\Models;

use App\Models\Governorate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    protected $fillable=[
        'governorate_id', 'city_name_ar', 'city_name_en', 'is_active'
    ];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
