<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'aktif'
        ]);

        // Create petugas users
        User::create([
            'name' => 'Petugas 1',
            'email' => 'petugas1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'status' => 'aktif'
        ]);

        User::create([
            'name' => 'Petugas 2',
            'email' => 'petugas2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'status' => 'aktif'
        ]);
    }
}
