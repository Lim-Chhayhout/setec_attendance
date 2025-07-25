<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teacher_positions')->insert([
            [
                'teacher_id' => '1',
                'title' => 'System analysis',
                'created_at' => now()
            ]
        ]);
    }
}
