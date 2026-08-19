<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;


class UserDirectoryController extends Controller
{
    public function getAllLandlords() {
        Log::info('starts of method');

        $landlords = User::role('landlord')->paginate(15);

Log::info( 'this number of landlords ' . $landlords->count());

        if($landlords->count() <= 0) {
            return response()->json([
                'landlords' => $landlords,
                'message' => 'No Landlords Found',
            ]);
        }

        $landlordCount = $landlords->count();
        Log::info('landlords ' . $landlordCount);

        return response()->json([
            'landlords' => $landlords->items(),
            'message' => 'Landlords Found',
            'landlord_count' => $landlordCount,
        ]);

    }
}
