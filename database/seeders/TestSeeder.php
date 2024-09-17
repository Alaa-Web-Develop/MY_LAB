<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Test::upsert(
            [
                [
                    'name' => 'test_1',
                    'tumor_id' => 5,
                    'details' => 'test_1 Details',
                    
                   
                   
                ],
                [
                    'name' => 'test_2',
                    'tumor_id' => 2,
                    'details' => 'test_2 Details',
                  
                  
                   

                ],
                [
                    'name' => 'test_3',
                    'tumor_id' => 3,
                    'details' => 'test_3 Details',
                    
                   
                   

                ],
                [
                    'name' => 'test_4',
                    'tumor_id' => 4,
                    'details' => 'test_4 Details',
                   
                   
                   

                ],
            ]
           , ['name', 'tumor_id', 'details',]);
   
    }
}
