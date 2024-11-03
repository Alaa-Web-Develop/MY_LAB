<?php

namespace App\Models;

use App\Models\LabOrder;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabOrderTestQuestion extends Model
{
    use HasFactory;
    protected $fillable=[
        'id', 'lab_order_id', 'question', 'answer', 'created_at', 'updated_at'
    ];

    public function labOrder()
    {
        return $this->belongsTo(LabOrder::class);
    }
    

}
