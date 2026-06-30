<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Listing;
class GeocodingService {

    public function geocode(Listing $listing) {
        $address = collect([
            $listing->address_line_1,
            $listing->address_line_2,
            $listing->town,
            $listing->county,
            $listing->postcode,
        ])->filter()->implode(',');

        $result = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address . ' United Kingdom',
            'key' => config('services.google.key'),
            'components' => 'country:GB',
        ]);
    }
}
