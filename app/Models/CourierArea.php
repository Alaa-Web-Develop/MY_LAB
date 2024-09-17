<?php

namespace App\Models;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourierArea extends Model
{
    use HasFactory;
    protected $fillable=[
'courier_id','area'
    ]; 
public function courier(){
    return $this->belongsTo(Courier::class,'courier_id');
}
}
