<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerLandlord(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole('landlord');

        Log::info($user->email . ' registered as landlord');
        return response()->json([
            'message' => 'successfully registered as landlord',
        ], 201);
    }

    public function registerBuyer(Request $request) {
        Log::info('method running');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole('buyer');

        Log::info($user->email . ' registered as buyer');

        return response()->json([
            'message' => 'successfully registered as buyer',
        ], 201);
    }

    public function login(Request $request) {

        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if(!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'These credentials do not match our records.',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'role' => $user->getRoleNames()->first(),
            'message' => 'Logged in successfully',
        ], 200);
    }

    public function logout() {
        $user = auth()->user();
        if($user) {
            $user->tokens()->delete();
        }
        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function currentUser(Request $request) {
        $user = User::findOrFail(auth('sanctum')->id());

        if(!$user) {
            return response()->json([
                'message' => 'currently not logged in',
            ]);
        }


        return response()->json([
            'user' => $user,
            'message' => 'user returned successfully',
        ]);
    }

    public function updateUserAccount(Request $request) {
        $user = auth('sanctum')->user();

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'contact' => 'sometimes|string|max:20',
            'email' => 'sometimes|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if(Hash::check($validatedData['password'], $user['password'])) {
            return response()->json([
                'message' => 'these credentials do not match our records.',
            ]);
        }

        $user->update(array_filter([
            'name' => $validatedData['name'] ?? null,
            'email' => $validatedData['email'] ?? null,
            'contact' => $validatedData['contact'] ?? null,
        ]));

        return response()->json([
            'message' => 'user values updated',
            'user' => $user->fresh(),
        ]);
    }

}
