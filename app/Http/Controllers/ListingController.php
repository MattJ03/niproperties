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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
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
