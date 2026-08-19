<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserDirectoryController extends Controller
{
    public function getAllLandlords() {
        $landlords = User::role('landlord')
                               ->with('listings')
            ->get();

        if($landlords->count() <= 0) {
            return response()->json([
                'landlords' => $landlords,
                'message' => 'No Landlords Found',
            ]);
        }

        $landlordCount = $landlords->count();
        return response()->json([
            'landlords' => $landlords,
            'message' => 'Landlords Found',
            'landlords_count' => $landlordCount,
        ]);

    }
}
