<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;

Route::post('/registerLandlord', [AuthController::class, 'registerLandlord']);
Route::post('/registerBuyer', [AuthController::class, 'registerBuyer']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/listingsIndex', [ListingController::class, 'index']);
