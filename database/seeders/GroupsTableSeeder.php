<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            ['group_name' => 'SU4.13', 'shift' => 'Afternoon', 'program' => 'Information Technology.'],
            ['group_name' => 'SU4.14', 'shift' => 'Afternoon', 'program' => 'Information Technology.']
        ]);

        DB::table('teacher_group_tokens')->insert([
            ['teacher_id' => '1',  'group_id' => '1'],
            ['teacher_id' => '1',  'group_id' => '2']
        ]);
    }
}
