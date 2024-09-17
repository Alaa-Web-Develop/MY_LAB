<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTranferRrequest extends Model
{
    use HasFactory;
    protected $fillable = ['doctor_id', 'points', 'status','transfer_phone_number','transfer_type','money','rejection_reason'];
    protected $table = 'points_transfer_requests'; // Ensure this matches the table name

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }


    // If earnedPoints is an attribute of an Eloquent model, you can define the attribute's type in the model's $casts array to ensure it is always treated as an integer:

    protected $casts = [
        'points' => 'integer',
    ];

}
