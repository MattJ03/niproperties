<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use App\Models\Listing;


class UserDirectoryController extends Controller
{
    public function getAllLandlords() {
        Log::info('starts of method');

        $landlords = User::role('landlord')
                               ->withCount('listings')
                               ->paginate(10);

      Log::info( 'this number of landlords ' . $landlords->count());

        if($landlords->count() <= 0) {
            return response()->json([
                'landlords' => $landlords->items(),
                'message' => 'No Landlords Found',
            ]);
        }

        $landlordCount = $landlords->total();

        Log::info('landlords ' . $landlordCount);

        return response()->json([
            'landlords' => $landlords->items(),
            'message' => 'Landlords Found',
            'landlord_count' => $landlordCount,
        ]);

    }

    public function showLandlord($id) {

        Log::info('starts of method');
        $landlord = User::with('listings')->findOrFail($id);
        Log::info('landlord found ' . $id);
        return response()->json([
            'landlord' => $landlord,
        ]);
}

public function getAllUsers() {
        $users = User::all();
        if($users->count() <= 0) {
            return response()->json([
                'users' => $users,
                'message' => 'no users found',
            ]);
        }

        return response()->json([
            'users' => $users,
            'user_count' => $users->count(),
            'message' => 'users Found',
        ]);
}

public function getLandlordsWithLargestPortfolios() {
        $landlords = User::role('landlord')->withCount('listings')->take(5)->get();

        if($landlords->count() <= 0) {
            return response()->json([
                'message' => 'no landlords found',
                'landlords' => $landlords->items(),
            ]);
        }

        return response()->json([
            'landlords' => $landlords->items(),
            'landlords_count' => $landlords->count(),
            'message' => 'landlords found',
        ]);
}
}
