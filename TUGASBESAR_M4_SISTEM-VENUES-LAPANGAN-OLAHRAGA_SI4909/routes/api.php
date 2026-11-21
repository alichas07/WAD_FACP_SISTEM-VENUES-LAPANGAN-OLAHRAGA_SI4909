<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\RentalItemController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CoachController;

Route::prefix('v1')->group(function () {
    Route::apiResource('venues', VenueController::class);
    Route::apiResource('rentals', RentalItemController::class);
    Route::apiResource('members', MemberController::class);
    Route::apiResource('coaches', CoachController::class);
});