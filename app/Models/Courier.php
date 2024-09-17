<?php

namespace App\Models;

use App\Models\User;
use App\Models\LabOrder;
use App\Models\CourierArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courier extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'email','user_id'];

    public function tests()
    {
        return $this->hasMany(LabOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function areas()
    {
        return $this->hasMany(CourierArea::class);
    }
    
}
