<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use App\Policies\ListingPolicy;
use App\Services\GeocodingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;

class ListingController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function index()
  {

      $userId = auth()->id();

      $query = Listing::where('sale_status', 'open');

      if ($userId) {
          $query->where('landlord_id', '!=', $userId);
      }
    $listings = $query->with('listingImages');

      if($listings->count() < 1) {
          Log::info($listings->count() . ' number of listings');
          return response()->json([
              'message' => 'there are no listings',
              'listings' => $listings,
          ]);
      }
      Log::info($query->count() . ' number of listings');
      $listings->orderBy('created_at', 'desc')->paginate(25);

      return response()->json([
          'listings' => $listings,
          'listings_count' => $listings->count(),
          'message' => 'listings found',
      ]);
  }


    public function store(Request $request, GeocodingService $geocodingService)
    {

        $this->authorize('create', Listing::class);

        $validatedData = $request->validate([
           'address_line_1' => 'required|string|max:255|min:3',
           'address_line_2' => 'nullable|string|max:255|min:3',
            'town' => 'required|string|max:255|min:3',
            'county' => 'required|string|max:40|min:3',
            'postcode' => 'required|string|max:40|min:3',
            'price' => 'required|numeric|min:1|max:100000000',
            'no_of_rooms' => 'required|numeric|min:1|max:45',
            'type' => 'required|string|max:40|min:3',
            'sale_status' => 'nullable|in:open',
        ]);

        $listing = Listing::create([
            'address_line_1' => $validatedData['address_line_1'],
            'address_line_2' => $validatedData['address_line_2'],
            'town' => $validatedData['town'],
            'county' => $validatedData['county'],
            'postcode' => $validatedData['postcode'],
            'price' => $validatedData['price'],
            'no_of_rooms' => $validatedData['no_of_rooms'],
            'type' => $validatedData['type'],
            'sale_status' => 'open',
            'description' => $request['description'],
            'landlord_id' => $request->user()->id,
            ]);

        $cords = $geocodingService->geocode($listing);

        if($cords) {
            $listing->update([
                'latitude' => $cords['lat'],
                'longitude' => $cords['lng'],
            ]);
        }

        return response()->json([
            'listing' => $listing,
            'message' => 'listing created',
        ], 201);
    }

    public function show(Request $request, Listing $listing)
    {
        $user = $request->user();
        if(auth()->check() && $user->hasRole('landlord') && $user->id === $listing->landlord_id) {
            return response()->json([
                'listing' => $listing,
                'message' => 'listing found',
            ], 200);
        }
        $listing->update([
            'views' => $listing->increment('views'),
        ]);
        $listing->refresh();

        return response()->json([
            'listing' => $listing,
            'message' => 'listing found and views incremented',
        ]);

    }




    public function update(Request $request, Listing $listing, GeocodingService $geocodingService)
    {
        $this->authorize('update', $listing);
        $validatedData = $request->validate([
            'address_line_1' => 'required|string|max:255|min:3',
            'address_line_2' => 'nullable|string|max:255|min:3',
            'town' => 'required|string|max:255|min:3',
            'county' => 'required|string|max:40|min:3',
            'postcode' => 'required|string|max:40|min:3',
            'price' => 'required|numeric|min:1|max:100000000',
            'no_of_rooms' => 'required|numeric|min:1|max:45',
            'type' => 'required|string|max:40|min:3',
            'sale_status' => 'required|in:open',
        ]);

        $listing->update([
            'address_line_1' => $validatedData['address_line_1'],
            'address_line_2' => $validatedData['address_line_2'],
            'town' => $validatedData['town'],
            'county' => $validatedData['county'],
            'postcode' => $validatedData['postcode'],
            'price' => $validatedData['price'],
            'no_of_rooms' => $validatedData['no_of_rooms'],
            'type' => $validatedData['type'],
            'sale_status' => $validatedData['sale_status'],
            'landlord_id' => $request->user()->id,
        ]);
        $cords = $geocodingService->geocode($listing);
        if($cords) {
            $listing->update([
                'latitude' => $cords['lat'],
                'longitude' => $cords['lng'],
            ]);
        }

        return response()->json([
            'listing' => $listing,
            'message' => 'listing updated',
        ], 201);
    }

    public function delete(Listing $listing) {
      $user = auth()->user();

      $this->authorize('delete', $listing);
      $listing->delete();

      return response()->json([
          'message' => 'listing deleted',
      ], 200);
    }

    public function get3MostRecentListings() {
      $userId = auth()->id();

      $query = Listing::where('sale_status', 'open');

          if($userId) {
              $query->where('landlord_id', '!=', $userId);

          }

          $listings = $query->with('listingImages')
              ->orderBy('created_at', 'desc')
              ->take(3)
              ->get();

      if($listings->count() < 1) {
          return response()->json([
              'message' => 'there are no listings',
              'listings' => $listings,
          ]);
      }

      return response()->json([
          'listings' => $listings,
          'message' => 'listings found',
      ]);
    }
}
