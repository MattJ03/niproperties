<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function toggleFavourite($id) {
       $user = auth('sanctum')->user();
       $listing = Listing::find($id);

       if(!$listing) {
           return response()->json([
               'message' => 'listing not found',
               'listing' => $listing,
           ]);
       }
       if(!$user->favourites()->where('listing_id', $listing->id)->exists()) {
           $user->favourites()->attach($listing->id);
       }
       if($user->favourites()->where('listing_id', $listing->id)->exists()) {
           $user->favourites()->detach($listing->id);
       }

       return response()->json([
           'listing' => $listing,
           'message' => 'favourite successfully',
       ]);

   }
}
