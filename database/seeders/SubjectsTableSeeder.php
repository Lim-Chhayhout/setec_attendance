<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'title' => 'System Analysis',
            ],
            [
                'title' => 'Web Development',
            ]
        ]);

        DB::table('teacher_subject_tokens')->insert([
            [
                'teacher_id' => '1',
                'subject_id' => '1',
            ],
            [
                'teacher_id' => '1',
                'subject_id' => '2',
            ]
        ]);
    }
}
