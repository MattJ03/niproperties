<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\ListingController;
use App\Models\Listing;
use Database\Factories\ListingFactory;
use Database\Factories\UserFactory;
use App\Models\User;

class ListingControllerTest extends TestCase
{
     use RefreshDatabase;
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function setUp(): void {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }

    public function test_index_method_returns_200_status_code(): void {
        $listings = Listing::factory()->count(1)->create();

        $response = $this->getJson('/api/listingsIndex');
        $response->assertStatus(200);
    }

    public function test_index_returns_the_correct_number_of_listings(): void {
        $listings = Listing::factory()->count(10)->create();

        $response = $this->getJson('/api/listingsIndex');
        $response->assertStatus(200);
        $this->assertDatabaseCount('listings', 10);
    }

    public function test_doesnt_return_listings_of_the_logged_in_landlord(): void {

        $user = User::factory()->create();
        $user->assignRole('landlord');
        $this->actingAs($user);

        $listings = Listing::factory()->count(10)->create([
            'sale_status' => 'open',
        ]);

        $listingsMine = Listing::factory()->count(10)->create([
            'sale_status' => 'open',
            'landlord_id' => $user->id,
        ]);

        $response = $this->getJson('/api/listingsIndex');
        $response->assertStatus(200);
        $this->assertDatabaseCount('listings', 20);
        $response->assertJsonFragment([
            'listings_count' => 10,
        ]);
    }

    public function test_index_returns_all_listings_for_landlord_if_none_are_theres(): void {
        $user = User::factory()->create();
        $user->assignRole('landlord');
        $this->actingAs($user);

        $listings = Listing::factory()->count(10)->create([]);
        $response = $this->getJson('/api/listingsIndex');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'listings_count' => 10,
        ]);
    }

    public function test_index_sends_message_saying_no_listings(): void {

        $response = $this->getJson('/api/listingsIndex');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'there are no listings',
        ]);
    }

    public function test_index_doesnt_return_listings_with_a_non_open_status(): void {
        $listings = Listing::factory()->count(10)->create([
            'sale_status' => 'closed',
        ]);

        $response = $this->getJson('/api/listingsIndex');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'there are no listings',
        ]);
    }

    public function test_get_paginated_results_from_listings(): void {
        $listings = Listing::factory()->count(10)->create();

        $response = $this->getJson('/api/listingsIndex');
        $response->assertStatus(200);
        $this->assertCount(10, $response->json('listings.data'));
    }

    public function test_store_listing_saves_to_db(): void {
        $landlord = User::factory()->create();
        $landlord->assignRole('landlord');
        $this->actingAs($landlord);

        $payload = Listing::factory()->make()->toArray();

        $response = $this->postJson('/api/storeListing', $payload);
        $response->assertStatus(201);


    }
}
