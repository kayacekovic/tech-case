<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developers = [
            [
                'name' => 'DEV1',
                'difficulty_level' => 1,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV2',
                'difficulty_level' => 2,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV3',
                'difficulty_level' => 3,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV4',
                'difficulty_level' => 4,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV5',
                'difficulty_level' => 5,
                'task_complete_duration' => 1,
            ],
        ];

        foreach ($developers as $developer) {
            DB::table('developers')->insert($developer);
        }
    }
}
