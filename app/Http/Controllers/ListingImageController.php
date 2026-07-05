<?php

namespace App\Http\Controllers;

use App\Models\ListingImage;
use Illuminate\Http\Request;

class ListingImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Listing $listing)
    {
        $this->authorize('create', [ListingImage::class, $listing]);

        $validatedImage = $request->validate([
           'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_primary' => 'boolean',

        ]);

        $path = $request->file('file')->store('listing-images/' . $listing->id, 'listings');

       $listingImage = $listing->listingImages()->create([
           'file_path' => $path,
           'file_type' => $request->file('file')->getClientOriginalName(),
           'is_primary' => $validatedImage['is_primary'] ?? false,
       ]);

       return response()->json([
           'listingImage' => $listingImage,
           'message' => "Image uploaded successfully.",
       ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ListingImage $listingImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListingImage $listingImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListingImage $listingImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListingImage $listingImage)
    {
        //
    }
}
