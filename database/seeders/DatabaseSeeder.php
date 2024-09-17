<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Doctor;
use App\Models\DoctorUser;
use App\Models\Lab_Branch_Test;
use App\Models\LabBranch;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
//Factories:

        //Seeders:
        // $this->call(AdminSeeder::class);
        // $this->call(CitySeeder::class);
        // $this->call(SpecialitiesSeeder::class);
        // $this->call(TumorsSeeder::class);
        // $this->call(InstitutionSeeder::class);
        // $this->call(DiagnosesSeeder::class);
        // $this->call(DoctorSeeder::class);
        // $this->call(LabsSeeder::class);
        // $this->call(LabBranchesSeeder::class);
        // $this->call(TestSeeder::class);
        // $this->call(PatientSeeder::class);
        
       

      
        // $this->call(PatientVisitSeeder::class);
        // $this->call(LabOrderSeeder::class);
        // $this->call(Lab_branche_test_Seeder::class);

        $this->call(LabTrackSeeder::class);
    }
}
