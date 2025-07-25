<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'user_id' => '1', 'major' => 'Information Technology', 
                'first_name' => 'Lim', 'last_name' => 'Chhayhout',
                'year' => '3', 'group_id' => '1',
                'province' => 'Phnom Penh', 'full_address' => 'No 153 Street C Borey New World Chhouk Meas, Phnom Penh Thmey, Sen Sok',
                'phone' => '012345678', 'image' => 'student1.png',
                'created_at' => now()
            ]
        ]);
    }
}
