<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use App\Policies\ListingPolicy;
use App\Services\GeocodingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

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

      if($query->count() < 1) {
          return response()->json([
              'message' => 'there are no listings',
              'listings' => $query,
          ]);
      }

      return response()->json([
          'listings' => $query->orderBy('created_at', 'desc')->paginate(20),
          'listings_count' => $query->count(),
          'message' => 'listings found',
      ]);
  }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
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
            'sale_status' => 'required|in:open',
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
