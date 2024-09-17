<?php

namespace Database\Seeders;

use App\Models\LabBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabBranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        LabBranch::upsert([
            [
                'name' => 'barnch_1',
                'phone' => '0111111111',
                'hotline' => '01111',
                'email' => 'lab_barnch_1@gmail.com',
                'governorate_id' => 3,
                'city_id' => 1,
                'location' => 'lab_1 location',
                'description' => 'lab_1 Description',
                'lab_id'=>2,
                'user_id'=> 2,
            ],
            [
                'name' => 'barnch_2',
                'phone' => '0222222222',
                'hotline' => '02222',
                'email' => 'lab_barnch_2@gmail.com',
                'governorate_id' => 4,
                'city_id' => 2,
                'location' => 'lab_2 location',
                'description' => 'lab_2 Description',
                'lab_id'=>1,
                'user_id'=>2 ,

            ],
            [
                'name' => 'barnch_3',
                'phone' => '0333333333',
                'hotline' => '03333',
                'email' => 'lab_barnch_3@gmail.com',
                'governorate_id' => 7,
                'city_id' => 3,
                'location' => 'lab_3 location',
                'description' => 'lab_3 Description',
                'lab_id'=>2,
                'user_id'=>3 , 

            ],
            [
                'name' => 'barnch_4',
                'phone' => '0444444444',
                'hotline' => '04444',
                'email' => 'lab_barnch_4@gmail.com',
                'governorate_id' => 4,
                'city_id' => 4,
                'location' => 'lab_4 location',
                'description' => 'lab_4 Description',
                'lab_id'=>2,
                'user_id'=>3 ,


            ],

        ], ['name', 'phone', 'hotline', 'email','governorate_id', 'city_id', 'location', 'description','lab_id','user_id','address']);
    }
}
