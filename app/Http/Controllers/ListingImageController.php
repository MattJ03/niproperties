<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Policies\ListingImagePolicy;

class ListingImageController extends Controller
{
    use AuthorizesRequests;
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
           'file_type' => $request->file('file')->getClientOriginalExtension(),
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

        return response()->file(
            Storage::disk('listings')->path($listingImage->file_path),
            [
                'Content-Type' => Storage::disk('listings')->mimeType($listingImage->file_path),
                'Content-Disposition' => 'inline; filename="' . basename($listingImage->file_path) . '"'
            ]
        );
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
        $this->authorize('delete', $listingImage);

        Storage::disk('listings')->delete($listingImage->file_path);
        $listingImage->delete();

        return response()->json([
            'message' => "Image deleted successfully.",
        ]);
    }
}
