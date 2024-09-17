<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['test_id', 'question', 'options'];

    protected $casts = [
        'options' => 'array', // Cast JSON to array
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
