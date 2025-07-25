<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teachers')->insert([
            [
                'user_id' => '2',
                'first_name' => 'Lim', 'last_name' => 'Chhayhout',
                'province' => 'Phnom Penh', 'full_address' => 'No 153 Street C Borey New World Chhouk Meas, Phnom Penh Thmey, Sen Sok',
                'phone' => '012345678', 'image' => 'teacher1.png',
                'created_at' => now()
            ]
        ]);
    }
}
