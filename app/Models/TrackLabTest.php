<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackLabTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'lab_order_id', 'expected_result_released_date', 'status','result','lab_received_at','result_released_at', 'notes','courier_collected_test_id'
    ];

// 
    protected $casts = [
        'result' => 'array',
        'expected_result_released_date'=>'datetime',
        'lab_received_at'=>'datetime',
        'result_released_at'=>'datetime',

    ];

    public function labOrder()
{
    return $this->belongsTo(LabOrder::class,'lab_order_id');
}
}
