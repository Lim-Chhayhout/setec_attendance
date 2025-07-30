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
                'username' => 'stdtest',
                'email' => 'test@student.com',
                'password' => Hash::make('123'),
                'role' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'tctest',
                'email' => 'test@teacher.com',
                'password' => Hash::make('123'),
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
