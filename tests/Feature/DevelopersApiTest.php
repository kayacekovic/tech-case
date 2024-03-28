<?php

namespace Tests\Feature;

use Tests\TestCase;

class DevelopersApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDevelopersApi(): void
    {
        $response = $this->get('/api/v1/developers');

        $response->assertStatus(200);
    }
}
