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
        $data = [
            [
                'full_name' => 'Admin',
                'email' => 'admin@bloomrate.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Abcd@1234'),
                'user_type' => 'admin',
                'is_verified' => '1',
                'is_admin' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        User::insert($data);
    }
}
