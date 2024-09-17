<?php

namespace Database\Seeders;

use App\Models\Lab_Branch_Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Lab_branche_test_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lab_Branch_Test::upsert([
            [
                'lab_id' => 1, 
                'test_id' =>1, 
                'price'=>20, 
                'points'=>20, 
                'notes'=>'notes1'
            ],
            [
                'lab_id' => 2, 
                'test_id' =>1, 
                'price'=>40, 
                'points'=>30, 
                'notes'=>'notes2'
            ],
            [
                'lab_id' => 2, 
                'test_id' =>1, 
                'price'=>30, 
                'points'=>40, 
                'notes'=>'notes3'
            ],
            [
                'lab_id' => 1,
                'test_id' =>2, 
                'price'=>30, 
                'points'=>40, 
                'notes'=>'notes4'
            ],
            [
                'lab_id' => 1,
                'test_id' =>1, 
                'price'=>30, 
                'points'=>40, 
                'notes'=>'notes5'
            ],
           
        ],[ ['lab_id', 'test_id', 'price', 'points', 'notes']]);
    }
}
