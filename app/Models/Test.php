<?php

namespace App\Models;

use App\Models\SponserTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'tumor_id', 'details', 'status','questions'
    ];

    // public function courier()
    // {
    //     return $this->belongsTo(Courier::class,'courier_id');
    // }

    public function questions()
    {
        return $this->hasMany(TestQuestion::class);
    }

    public function sponsoredTests()
    {
        return $this->hasMany(SponserTest::class);
    }

    //Rel
    public function tumor()
    {
        return $this->belongsTo(Tumor::class)->withDefault();
    }

 

    public function labs()
    {
        return $this->belongsToMany(Lab::class,'lab_tests')->withPivot(['price', 'points', 'notes','discount_points']);
    }

    public function LabOrder()
    {
        return $this->belongsTo(LabOrder::class);
    }


    protected $casts = [
        'questions' => 'array', // Automatically cast JSON to array
    ];

}
