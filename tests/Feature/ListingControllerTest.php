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
        $this->assertDatabaseHas('listings', [
            'landlord_id' => $landlord->id,
        ]);
    }

    public function test_store_listing_requires_landlord_id(): void {
        $user = User::factory()->create();
        $user->assignRole('buyer');
        $this->actingAs($user);

        $listing = Listing::factory()->make([
            'landlord_id' => $user->id,
        ]);

        $response = $this->postJson('/api/storeListing', $listing->toArray());
        $response->assertStatus(403);
        }

        public function test_guest_cannot_create_listing(): void {

        $listing = Listing::factory()->make()->toArray();
        $response = $this->postJson('/api/storeListing', $listing);
        $response->assertStatus(401);

        }

        public function test_no_mass_assignment_bug_even_when_other_landlord_tries_it(): void {
        $user = User::factory()->create();
        $user->assignRole('landlord');
        $this->actingAs($user);

        $user2 = User::factory()->create()->assignRole('landlord');
        $user2->id = 2;

        $listing = Listing::factory()->make([
            'landlord_id' => $user2->id,
        ])->toArray();

        $response = $this->postJson('/api/storeListing', $listing);
        $response->assertStatus(201);
        $this->assertDatabaseMissing('listings', [
            'landlord_id' => $user2->id,
        ]);
        }

        public function test_guest_cannot_store_listing_for_landlord_id_through_mass_assignment_bug(): void {
        $landlord = User::factory()->create();
        $landlord->assignRole('landlord');
        $landlordId = $landlord->id;

            $listing = Listing::factory()->make([
                'landlord_id' => $landlordId,
            ])->toArray();
            $response = $this->postJson('/api/storeListing', $listing);
            $response->assertStatus(401);
        }

        public function test_show_method_returns_listing_when_user_logged_in(): void {
        $user = User::factory()->create();
        $this->actingAs($user);
        $listing = Listing::factory()->create();

        $response = $this->getJson('/api/listing/' . $listing->id);
        $response->assertStatus(200);

        }

        public function test_guest_can_hit_show_listing_endpoint(): void {
        $listing = Listing::factory()->create();

        $response = $this->getJson('/api/listing/' . $listing->id);
        $response->assertStatus(200);
        }

        public function test_increment_goes_up_by_one_when_viewed_not_by_landlord_of_the_listing(): void {
        $user = User::factory()->create()->assignRole('landlord');
        $this->actingAs($user);

        $listing = Listing::factory()->create([
            'landlord_id' => $user->id,
        ]);

        $response = $this->getJson('/api/listing/' . $listing->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('listings', [
            'views' => 1
        ]);
        }

        public function test_increment_views_when_viewed_not_by_landlord_of_the_listing(): void {
        $user = User::factory()->create()->assignRole('buyer');
        $this->actingAs($user);
        $listing = Listing::factory()->create();

        $response = $this->getJson('/api/listing/' . $listing->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('listings', [
            'views' => 1
        ]);
        }

        public function test_correct_listing_being_returned(): void {
        $listing = Listing::factory()->create([
            'town' => 'fakeTown'
        ]);

        $response = $this->getJson('/api/listing/' . $listing->id);
        $response->assertStatus(200);
        $this->assertDatabaseHas('listings', [
            'town' => 'fakeTown',
        ]);
        }

        public function test_update_method_updates_fields(): void {
        $user = User::factory()->create()->assignRole('landlord');
        $this->actingAs($user);

        $listing = Listing::factory()->create([
            'landlord_id' => $user->id,
        ]);

        $updatedListing = Listing::factory()->make([
            'landlord_id' => $user->id,
            'town' => 'updatedTown'
        ])->toArray();

        $response = $this->putJson('/api/updateListing/' . $listing->id, $updatedListing);

        $response->assertStatus(201);
        $this->assertDatabaseHas('listings', [
            'town' => 'updatedTown',
        ]);
        }

        public function test_cant_update_listing_which_isnt_yours(): void {
        $user = User::factory()->create()->assignRole('landlord');
        $this->actingAs($user);
        $listing = Listing::factory()->create();

        $updatedListing = Listing::factory()->make([
           'landlord_id' => $user->id,
        ])->toArray();

        $response = $this->putJson('/api/updateListing/' . $listing->id, $updatedListing);
        $response->assertStatus(403);
        }

        public function test_update_returns_the_updated_listing(): void {
        $user = User::factory()->create()->assignRole('landlord');
        $this->actingAs($user);
        $listing = Listing::factory()->create([
            'landlord_id' => $user->id,
        ]);

        $updatedListing = Listing::factory()->make([
            'landlord_id' => $user->id,
            'county' => 'fakeCity',
        ])->toArray();

        $response = $this->putJson('/api/updateListing/' . $listing->id, $updatedListing);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'listing',
        ]);
        }

        public function test_delete_method_deletes_listing(): void {
        $user = User::factory()->create()->assignRole('landlord');
        $this->actingAs($user);

        $listing = Listing::factory()->create([
            'landlord_id' => $user->id,
        ]);

        $this->assertDatabaseCount('listings', 1);

        $response = $this->deleteJson('api/deleteListing/' . $listing->id);
        $response->assertStatus(200);
        $this->assertDatabaseCount('listings', 0);
        }

        public function test_delete_cannot_delete_when_guest(): void {
        $listing = Listing::factory()->create();

        $response = $this->deleteJson('/api/deleteListing/' . $listing->id);
        $response->assertStatus(401);
        }

        public function test_buyer_cannot_delete_the_listing(): void {
        $user = User::factory()->create()->assignRole('buyer');
        $this->actingAs($user);

        $listing = Listing::factory()->create();

        $response = $this->deleteJson('/api/deleteListing/' . $listing->id);
        $response->assertStatus(403);
        }

        public function test_landlord_cannot_delete_another_landlords_listing(): void {
        $user = User::factory()->create()->assignRole('landlord');
        $this->actingAs($user);

        $listing = Listing::factory()->create([
            'town' => 'fakeTown',
            ]);

        $response = $this->deleteJson('/api/deleteListing/' . $listing->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('listings', [
            'town' => 'fakeTown',
        ]);
        }
}
