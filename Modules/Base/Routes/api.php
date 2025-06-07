<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Base\Http\Controllers\EnumController;
use Modules\Base\Http\Controllers\SubwayController;


// Enums

Route::prefix('currency')->group(function () {
    Route::get('/', [EnumController::class, 'currencies']);
});

Route::prefix('property-types')->group(function () {

    Route::get('/', [EnumController::class, 'propertyTypes']);
});
Route::prefix('repair-types')->group(function () {

    Route::get('/', [EnumController::class, 'repairTypes']);
});

Route::prefix('room-count')->group(function () {

    Route::get('/', [EnumController::class, 'roomCount']);
});
//End Enums


// Start Model Request

Route::prefix('subway')->group(function () {
    Route::get('/', [SubwayController::class, 'list']);
});


Route::middleware('auth:api')->get('/base', function (Request $request) {
    return $request->user();
});
