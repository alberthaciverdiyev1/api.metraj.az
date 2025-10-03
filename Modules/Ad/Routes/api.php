<?php

use Illuminate\Http\Request;
use Modules\Ad\Http\Controllers\AdController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::get('/ads/active', [AdController::class, 'getActiveAds']);

// Authenticated routes - Agency users
Route::middleware('auth:api')->group(function () {
    
    // Agency can manage their own ads
    Route::get('/ads', [AdController::class, 'list']);
    Route::post('/ads', [AdController::class, 'add']);
    Route::put('/ads/{id}', [AdController::class, 'edit']);
    Route::delete('/ads/{id}', [AdController::class, 'delete']);
});

// Admin routes for status management
Route::middleware('auth:api')->group(function () {
    Route::put('/ads/{id}/status', [AdController::class, 'changeStatus']);
});

