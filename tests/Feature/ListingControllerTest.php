<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\ListingController;
use App\Models\Listing;
use Database\Factories\ListingFactory;

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
}
