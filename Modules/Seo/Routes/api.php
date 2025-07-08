<?php

use Illuminate\Http\Request;
use Modules\Seo\Http\Controllers\SeoController;

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


Route::controller(SeoController::class)->prefix('seo')->group(function () {
    Route::get('/', [\Modules\Seo\Http\Controllers\SeoController::class, 'index']);
    Route::get('/{page}', [\Modules\Seo\Http\Controllers\SeoController::class, 'details']);
    Route::post('/', [\Modules\Seo\Http\Controllers\SeoController::class, 'store']);
    Route::put('/{id}', [\Modules\Seo\Http\Controllers\SeoController::class, 'update']);
    Route::delete('/{id}', [\Modules\Seo\Http\Controllers\SeoController::class, 'delete']);
});

//Route::middleware('auth:api')->group(function () {
//    Route::resource('/seo', \Modules\Seo\Http\Controllers\SeoController::class);
//});

