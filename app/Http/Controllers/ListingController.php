<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Policies\ListingPolicy;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->id();
        $this->authorize('viewAny', Listing::class);

        $listings = Listing::where('status', 'open')
                             ->where('landlord_id', '!==', $user->id)
                              ->orderBy('created_at', 'desc')
                              ->paginate(20);

        if($listings->count() <= 0) {
            return response()->json([
                'message' => 'No listings found.',
                'listings' => $listings,
            ], 200);
        }

        return response()->json([
            'listings' => $listings,
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
