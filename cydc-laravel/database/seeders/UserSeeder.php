<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user
        User::create([
            'email' => 'test@example.com',
            'phone' => '+255123456789',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'user',
            'status' => 'approved',
        ]);

        // Create admin user
        User::create([
            'email' => 'idrissmwala11@gmail.com',
            'phone' => '+255987654321',
            'password' => Hash::make('Idriss@66'),
            'role' => 'admin',
            'status' => 'approved',
            'email_verified_at' => now(),
        ]);
    }
}
