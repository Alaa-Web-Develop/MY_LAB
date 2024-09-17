<?php

namespace Database\Seeders;

use App\Models\PatientCase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */  //
    public function run(): void
    {
        PatientCase::upsert([
            [
                'patient_id'=>4 ,
                'doctor_id' =>1 ,
                     
                
                'diagnose_id' =>5 ,
                'comment' =>'comment oo' ,

            ],
            [
                'patient_id'=>4 ,
                'doctor_id' =>1 ,
                        
                
                'diagnose_id' =>2 ,
                'comment' =>'comment hh' ,

            ],
            [
                'patient_id'=>4 ,
                'doctor_id' =>1 ,
                      
                
                'diagnose_id' =>3 ,
                'comment' =>'comment pp' ,

            ],
        ],['patient_id','doctor_id', 'pathology_report_image', 'diagnose_id', 'comment']);
    }
}
