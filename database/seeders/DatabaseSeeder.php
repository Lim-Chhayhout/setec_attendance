<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \Illuminate\Support\Facades\DB::table('users')->truncate();
        // \Illuminate\Support\Facades\DB::table('roles')->truncate();
        // \Illuminate\Support\Facades\DB::table('groups')->truncate();

        $this->call([
            UsersTableSeeder::class,
            StudentsTableSeeder::class,
            TeachersTableSeeder::class,
            GroupsTableSeeder::class,
            TeacherPositionsTableSeeder::class
        ]);
    }
}
