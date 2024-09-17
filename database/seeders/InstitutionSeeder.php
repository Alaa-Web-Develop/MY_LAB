<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institution::upsert([
            ['name' =>'Institution1' ],
            ['name' =>'Institution2' ],
            ['name' =>'Institution3' ],
            ['name' =>'Institution4' ],
            ['name' =>'Institution5' ],
            ['name' =>'Institution6' ],
            ['name' =>'Institution7' ],
            
            
                    ],['name']);
    }
}
