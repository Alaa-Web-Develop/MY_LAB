<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::upsert([
            [
                'firstname'=>'Alaa' ,
                'lastname' =>'Elattar' ,
                'doctor_id' =>2 ,         
                
                'phone' =>'01111111111' ,
                'email' =>'alaa@mail.com' ,
                'age' =>20 ,
                'comment' =>'comment alaa patient',
                
            ],
            [
                'firstname'=>'Sayed' ,
                'lastname' =>'Mohamed' ,
                'doctor_id' =>2 ,
               
                'phone' =>'02222222222' ,
                'email' =>'Sayed@mail.com' ,
                'age' =>30 ,
                'comment' =>'comment Sayed patient',
                

            ],
            [
                'firstname'=>'Mohsen' ,
                'lastname' =>'Monir' ,
                'doctor_id' =>1 ,
               
                'phone' =>'03333333333' ,
                'email' =>'Mohsen@mail.com' ,
                'age' =>30 ,
                'comment' =>'comment Mohsen patient',
                 

            ],
            [
                'firstname'=>'Somia' ,
                'lastname' =>'Naguib' ,
                'doctor_id' =>1 ,
              
                'phone' =>'0444444444' ,
                'email' =>'Somia@mail.com' ,
                'age' =>40 ,
                'comment' =>'comment Somia patient',
                 

            ],
        ],['firstname', 'lastname', 'doctor_id', 'pathology_report_image', 'phone', 'email', 'age', 'comment']);
    }
}
