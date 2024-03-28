<?php

namespace Tests\Feature;

use Tests\TestCase;

class SprintsApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSprintsApi(): void
    {
        $response = $this->get('/api/v1/sprints');

        $response->assertStatus(200);
    }
}
