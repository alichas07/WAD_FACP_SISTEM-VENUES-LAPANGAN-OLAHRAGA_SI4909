<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // followingRedirects() akan mengikuti redirect dari '/' sampai tiba di halaman '/venues'
        $response = $this->followingRedirects()->get('/');

        $response->assertStatus(200);
    }
}
