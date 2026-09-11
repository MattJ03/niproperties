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
            'users_count' => 5,
        ]);
    }
}
