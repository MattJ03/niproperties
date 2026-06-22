<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\AuthController;
use Database\Seeders\DatabaseSeeder;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function __setUp(): void {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_register_landlord(): void {
        $user = [
            'name' => 'Test User',
            'email' => 'real@email.com',
            'contact' => '0123456789',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/registerLandlord', $user);
        $response->assertStatus(201);
    }
}
