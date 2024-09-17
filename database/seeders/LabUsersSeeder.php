<?php

namespace Database\Seeders;

use App\Models\LabUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LabUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LabUser::create([
            'name' => 'lab_user',
            'email' => 'lab_user@lab.com',
            'username' => 'lab_username',
            'password' => Hash::make('password'),
            'phone_number' => '01006664023',
            'status' => 'active'
        ]);
    }
}
