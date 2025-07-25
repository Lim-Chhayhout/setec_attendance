<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'std00001',
                'email' => 'test@student.com',
                'password' => Hash::make('12345678'),
                'role' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'tc00001',
                'email' => 'test@teacher.com',
                'password' => Hash::make('123'),
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
