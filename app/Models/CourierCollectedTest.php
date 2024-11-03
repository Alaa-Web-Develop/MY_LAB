<?php

namespace App\Models;

use App\Models\Lab;
use App\Models\Courier;
use App\Models\Patient;
use App\Models\LabOrder;
use App\Models\LabBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourierCollectedTest extends Model
{
    use HasFactory;
    protected $fillable=[
        'courier_id','lab_order_id','status','collected_at'
    ];

    public function labOrder()
{
    return $this->belongsTo(LabOrder::class,'lab_order_id');
}

protected $casts = [
    'collected_at' => 'datetime',
];

public function courier()
{
    return $this->belongsTo(Courier::class);
}



}
