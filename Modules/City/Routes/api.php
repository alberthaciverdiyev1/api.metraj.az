<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\City\Http\Controllers\CityController;

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
Route::get('cities', [\Modules\City\Http\Controllers\CityController::class, 'index']);

Route::controller(CityController::class)->group(function () {
    Route::get('city', 'list')->name('city.list');
    Route::get('city/{slug}', 'details')->name('city.details');
    Route::post('city', 'store')->name('city.store');
    Route::put('city/{slug}', 'update')->name('city.update');
    Route::delete('city/{slug}', 'destroy')->name('city.delete');
});

//Route::middleware('auth:api')->get('/city', function (Request $request) {
//    return $request->user();
//});
