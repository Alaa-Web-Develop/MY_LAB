<?php

namespace App\Models;

use App\Models\Test;
use App\Models\Sponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SponserTest extends Model
{
    use HasFactory;
    protected $fillable = ['test_id', 'sponser_id', 'quota','lab_id'];
    protected $table='sponser_tests';

    public function test()
    {
        return $this->belongsTo(Test::class,'test_id');
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class,'lab_id');
    }


    public function sponsor()
    {
        return $this->belongsTo(Sponser::class,'sponser_id');
    }
}
