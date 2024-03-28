<?php

namespace Tests\Feature;

use Tests\TestCase;

class TasksApiTest extends TestCase
{
    public function testTasksApi(): void
    {
        $response = $this->get('/api/v1/tasks');

        $response->assertStatus(200);
    }

    public function testTasksStatsApi(): void
    {
        $response = $this->get('/api/v1/tasks/stats');

        $response->assertStatus(200);
    }
}
