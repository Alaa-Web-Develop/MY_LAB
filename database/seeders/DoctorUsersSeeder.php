<?php

namespace Database\Seeders;

use App\Models\DoctorUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DoctorUser::create([
            'name' => 'doc_user',
            'email' => 'doc_user@lab.com',
            'username' => 'doc_username',
            'password' => Hash::make('password'),
            'phone_number' => '01005554023',
            'status' => 'active'
        ]);
    }
}
