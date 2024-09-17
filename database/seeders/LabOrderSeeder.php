<?php

namespace Database\Seeders;

use App\Models\LabOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LabOrder::upsert([
            [
                'patient_id' => 4,
                'doctor_id' =>2,
                'test_id' =>4,
                'lab_branche_id'=>1,
                'lab_id'=>1,
                'patient_case_id' =>1
            ],
            [
              'patient_id' => 4,
                'doctor_id' =>2,
                'test_id' =>1,
                'lab_branche_id'=>2,
                'lab_id'=>1,

                'patient_case_id' =>1

            ],
            [
             'patient_id' => 4,
                'doctor_id' =>2,
                'test_id' =>2,
                'lab_branche_id'=>3,
                'patient_case_id' =>2,
                'lab_id'=>2,


            ],
            [
             'patient_id' => 4,
                'doctor_id' =>2,
                'test_id' =>3,
                'lab_branche_id'=>4,
                'patient_case_id' =>2,
                'lab_id'=>1,


            ],
            [
           'patient_id' => 4,
                'doctor_id' =>2,
                'test_id' =>4,
                'lab_branche_id'=>4,
                'patient_case_id' =>3,
                'lab_id'=>2,


            ],
            [
            'patient_id' => 4,
                'doctor_id' =>1,
                'test_id' =>3,
                'lab_branche_id'=>2,
                'patient_case_id' =>3,
               
                'lab_id'=>2,

            ],
            [
             'patient_id' => 4,
                'doctor_id' =>2,
                'test_id' =>4,
                'lab_branche_id'=>3,
                'patient_case_id' =>3,
                'lab_id'=>2,


            ],
        ],
        ['patient_id', 'doctor_id', 'test_id', 'lab_branche_id','lab_id']);
    }
}
