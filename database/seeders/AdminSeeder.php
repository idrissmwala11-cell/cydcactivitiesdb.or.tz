<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'idrissmwala11@gmail.com'],
            [
                'email' => 'idrissmwala11@gmail.com',
                'password' => Hash::make('Idriss@66'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}
