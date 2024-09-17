<?php

namespace Database\Seeders;

use App\Models\Lab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lab::upsert([
            [
                'name' => 'lab_1_name',
                'phone' => '0111111111',
                'hotline' => '01111',
                'email' => 'lab_1@gmail.com',
                'governorate_id' => 1,
                'city_id' => 1,
                'location' => 'lab_1 location',
                'description' => 'lab_1 Description',
           

            ],
            [
                'name' => 'lab_2_name',
                'phone' => '0222222222',
                'hotline' => '02222',
                'email' => 'lab_2@gmail.com',
                'governorate_id' => 2,
                'city_id' => 2,
                'location' => 'lab_2 location',
                'description' => 'lab_2 Description',
            

            ],
       

        ], ['name', 'phone', 'hotline', 'email','governorate_id', 'city_id', 'location', 'description','address']);
    }
}
