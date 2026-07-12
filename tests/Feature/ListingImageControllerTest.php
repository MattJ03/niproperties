<?php

namespace Tests\Feature;

use App\Models\ListingImage;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Factories\ListingImageFactory;

class ListingImageControllerTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_store_image(): void {
        $user = User::factory()->create();
        $user->assignRole('landlord');
        $this->actingAs($user);

        $listingImage = ListingImage::factory()->make()->toArray();

        $response = $this->postJson('api/storeListingImage', $listingImage);
        $response->assertStatus(201);
    }
}
