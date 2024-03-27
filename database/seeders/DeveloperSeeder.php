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
                'ability_level' => 1,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV2',
                'ability_level' => 2,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV3',
                'ability_level' => 3,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV4',
                'ability_level' => 4,
                'task_complete_duration' => 1,
            ],
            [
                'name' => 'DEV5',
                'ability_level' => 5,
                'task_complete_duration' => 1,
            ],
        ];

        foreach ($developers as $developer) {
            DB::table('developers')->insert($developer);
        }
    }
}
