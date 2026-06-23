<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\AuthController;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function setUp(): void {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_register_landlord(): void {
        $user = [
            'name' => 'Test User',
            'email' => 'real@email.com',
            'contact' => '0123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/registerLandlord', $user);
        $response->assertStatus(201);
    }

    public function test_register_landlord_no_password_confirmation(): void {
        $user = [
            'name' => 'Test User',
            'email' => 'test@email.com',
            'contact' => '0123456789',
            'password' => 'password',
        ];
        $response = $this->postJson('/api/registerLandlord', $user);
        $response->assertStatus(422);

    }

    public function test_landlord_assigned_correct_role(): void {
        $landlord = [
            'name' => 'Test User',
            'email' => 'email@fake.com',
            'contact' => '0123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/registerLandlord', $landlord);

        $user = User::first();
        $this->assertTrue($user->hasRole('landlord'));
        $response->assertStatus(201);
    }

    public function test_landlord_register_requires_name(): void {
        $landlord = [
            'email' => 'fake@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/registerLandlord', $landlord);
        $response->assertStatus(422);
    }

    public function test_landlord_register_adds_to_the_user_table(): void {
        $payload = [
            'name' => 'Test User',
            'email' => 'email@user.com',
            'contact' => '0123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/registerLandlord', $payload);
        $response->assertStatus(201);
        $landlord = User::where('email', $payload['email'])->first();
        $this->assertEquals($payload['name'], $landlord->name);
    }
}
