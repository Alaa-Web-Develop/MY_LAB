<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Dr Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'type' => 'admin'
        ]);
        User::create([
            'name' => 'Dr lab1',
            'email' => 'lab1@lab.com',
            'password' => Hash::make('password'),
            'type' => 'lab'
        ]);
        User::create([
            'name' => 'Dr lab2',
            'email' => 'lab2@lab.com',
            'password' => Hash::make('password'),
            'type' => 'lab'
        ]);
        User::create([
            'name' => 'Dr Admin2',
            'email' => 'admin2@admin.com',
            'password' => Hash::make('password'),
            'type' => 'admin'
        ]);
        User::create([
            'name' => 'Dr doctor1',
            'email' => 'doctor1@admin.com',
            'password' => Hash::make('password'),
            'type' => 'doctor'
        ]);
        User::create([
            'name' => 'Dr doctor2',
            'email' => 'doctor2@admin.com',
            'password' => Hash::make('password'),
            'type' => 'doctor'
        ]);
    }
}
