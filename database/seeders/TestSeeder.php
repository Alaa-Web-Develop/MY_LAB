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
                    'diagnose_id' => 5,
                    'details' => 'test_1 Details',
                    
                   
                   
                ],
                [
                    'name' => 'test_2',
                    'diagnose_id' => 2,
                    'details' => 'test_2 Details',
                  
                  
                   

                ],
                [
                    'name' => 'test_3',
                    'diagnose_id' => 3,
                    'details' => 'test_3 Details',
                    
                   
                   

                ],
                [
                    'name' => 'test_4',
                    'diagnose_id' => 4,
                    'details' => 'test_4 Details',
                   
                   
                   

                ],
            ]
           , ['name', 'diagnose_id', 'details',]);
   
    }
}
