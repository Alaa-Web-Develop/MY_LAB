<?php

namespace Database\Seeders;

use App\Models\Tumor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TumorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tumor::upsert([
            ['name' =>'tumor_type1' ],
            ['name' =>'tumor_type2' ],
            ['name' =>'tumor_type3' ],
            ['name' =>'tumor_type4' ],
            ['name' =>'tumor_type5' ],
            ['name' =>'tumor_type6' ],
            ['name' =>'tumor_type7' ],
            
            
                    ],['name']);
    }
}
