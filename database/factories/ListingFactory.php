<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\UserFactory;
use App\Models\User;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $landlord = User::factory()->create();
        $landlord->assignRole('landlord');

        return [
            'address_line_1' => fake()->streetAddress(),
            'town' => fake()->city(),
            'county' => fake()->country(),
            'postcode' => fake()->postcode(),
            'price' => fake()->numberBetween(50000, 100000),
            'no_of_rooms' => fake()->numberBetween(1, 10),
            'type' => fake()->randomElement(['house', 'apartment', 'commercial']),
            'sale_status' => 'open',
            'landlord_id' => $landlord->id,
        ];
    }
}
