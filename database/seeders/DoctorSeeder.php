<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::query()->create([
            'name' => 'Dr Mohamed',
            'institution_id' => 1,
            'speciality_id' => 2,
            'governorate_id' => 1,
            'city_id' => 1,
            'phone' => "01065487856",
            'email' => 'doctor@doctor.com',
            'user_id'=> 1,
          ]);
          Doctor::query()->create([
            'name' => 'Dr Ahmed',
            'institution_id' => 2,
            'speciality_id' => 2,
            'governorate_id' => 2,
            'city_id' => 2,
            'phone' => "0122225544",
            'email' => 'Ahmed@gmail.com',
            'user_id'=> 2,

          ]);
          
    }
}


