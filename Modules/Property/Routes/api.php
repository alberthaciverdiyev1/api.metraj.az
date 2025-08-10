<?php

use Illuminate\Http\Request;
use Modules\Property\Http\Controllers\PropertyController;
use Modules\User\Http\Controllers\FavoriteController;

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


Route::group(['prefix' => 'property'], function () {

    Route::get('/', [PropertyController::class, 'list']);
    Route::get('/{id}', [PropertyController::class, 'details']);
    Route::post('/', [PropertyController::class, 'add']);
    Route::put('/{id}', [PropertyController::class, 'update']);
    Route::delete('/{id}', [PropertyController::class, 'delete']);
    Route::put('/make-premium', [PropertyController::class, 'makePremium']);
    Route::put('/make-move-forward', [PropertyController::class, 'moveForward']);
});

Route::get('agency-property/{id}', [PropertyController::class, 'agencyProperties']);

Route::controller(FavoriteController::class)->prefix('favorite')->group(function () {
    Route::get('/', 'index')->name('favorite.list');
    Route::post('/', 'store')->name('favorite.store');
    Route::delete('/{property_id}', 'destroy')->name('favorite.destroy');
});


//Route::middleware('auth:api')->group(function () {
//    Route::resource('/property', \Modules\Property\Http\Controllers\PropertyController::class);
//});

