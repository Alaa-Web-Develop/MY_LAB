<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::unguard();
        Governorate::unguard();

        $citiesPath=base_path('database/mySql/cities.sql');
        DB::unprepared(file_get_contents($citiesPath));
    }
}
