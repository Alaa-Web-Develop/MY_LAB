<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\SponserTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSponserdTest extends Model
{
    use HasFactory;
    protected $fillable = ['doctor_id', 'sponser_test_id', 'quota_remaining'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function sponsoredTest()
    {
        return $this->belongsTo(SponserTest::class);
    }
}
