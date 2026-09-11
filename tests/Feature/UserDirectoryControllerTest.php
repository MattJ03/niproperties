<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Factories\UserFactory;
use Spatie\Permission\Models\Role;


class UserDirectoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function setUp(): void{
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_users_returns_all_users(): void {
        $users = User::factory()->count(5)->create();

        $response = $this->getJson('/api/getUsers');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'user_count' => 5,
        ]);
    }

    public function test_get_users_returns_users_count_regardless_role(): void {
        $landlords = User::factory()->count(5)->create();
        $buyers = User::factory()->count(5)->create();

        $response = $this->getJson('/api/getUsers');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'user_count' => 10,
        ]);
    }

    public function test_get_user_returns_no_users_message_when_users_table_empty(): void {
        $response = $this->getJson('/api/getUsers');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'no users found',
        ]);
    }
}
