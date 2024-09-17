<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackLabTest extends Model
{
    use HasFactory;
    protected $fillable = [
        'lab_order_id', 'expected_result_released_date', 'status', 'delivered_at', 'result','result_released_at', 'notes'
    ];


    protected $casts = [
        'result' => 'array',
    ];

    public function labOrder()
{
    return $this->belongsTo(LabOrder::class);
}
}
