<?php

namespace Database\Seeders;

use App\Models\Diagnose;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiagnosesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Diagnose::upsert([
            ['name' =>'Diagnose1' ],
            ['name' =>'Diagnose2' ],
            ['name' =>'Diagnose3' ],
            ['name' =>'Diagnose4' ],
            ['name' =>'Diagnose5' ],
            ['name' =>'Diagnose6' ],
            ['name' =>'Diagnose7' ],
            
            
                    ],['name']);
    }
}
