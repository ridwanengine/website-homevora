<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // cek apakah admin sudah ada
        if (!User::where('email', 'admin@gmail.com')->exists()) {

            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
            ]);
        }
    }
}
