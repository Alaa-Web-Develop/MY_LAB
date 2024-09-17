<?php

namespace Database\Seeders;

use App\Models\Speciality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Speciality::upsert([
['name' =>'Clinical Oncology' ],
['name' =>'Medical Oncology' ],
['name' =>'Radiation Oncology' ],
['name' =>'Surgical Oncology' ],
['name' =>'Interventional Radiology' ],
['name' =>'Pathology' ],
['name' =>'Molecular biology' ],


        ],['name']);
    }
}

// Flight::upsert([
//     ['departure' => 'Oakland', 'destination' => 'San Diego', 'price' => 99],
//     ['departure' => 'Chicago', 'destination' => 'New York', 'price' => 150]
// ], ['departure', 'destination'], ['price']);

// multiple "upserts" in a single query, then you should use the upsert method instead. The method's first argument consists of the values to insert or update, while the second argument lists the column(s) that uniquely identify records within the associated table. The method's third and final argument is an array of the columns that should be updated if a matching record already exists in the database. The upsert method will automatically set the created_at and updated_at timestamps if timestamps are enabled on the model:

