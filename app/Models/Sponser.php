<?php

namespace App\Models;

use App\Models\SponserTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponser extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo'];

    public function sponsoredTests()
    {
        return $this->hasMany(SponserTest::class);
    }
}
