<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'owner',
            'email' => 'owner@example.com',
            'role' => 'owner',
            // 'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            // 'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => 'kasir',
            'email' => 'kasir@example.com',
            'role' => 'cashier',
            // 'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
