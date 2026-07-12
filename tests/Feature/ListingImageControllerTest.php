<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\ListingImage;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use Database\Factories\ListingImageFactory;
use Illuminate\Support\Facades\Storage;

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

    public function test_store_image(): void
    {
        Storage::fake('listings');

        $user = User::factory()->create();
        $user->assignRole('landlord');

        $listing = Listing::factory()->create(['landlord_id' => $user->id]);

        $file = UploadedFile::fake()->image('house.jpg');

        $response = $this->actingAs($user)
            ->post("/api/listings/{$listing->id}/images", [
                'file' => $file,
                'is_primary' => true,
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('listing_images', [
            'listing_id' => $listing->id,
            'is_primary' => true,
        ]);

        $image = ListingImage::first();
        Storage::disk('listings')->assertExists($image->file_path);
    }
}
