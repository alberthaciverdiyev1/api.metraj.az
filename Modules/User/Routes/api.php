<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

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

Route::get('user', [\Modules\User\Http\Controllers\UserController::class, 'list']);

Route::controller(UserController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [\Modules\User\Http\Controllers\UserController::class, 'logout']);
    Route::get('test', function (Request $request) {
        return auth()->user();
    });
    Route::post('update-banner', [\Modules\User\Http\Controllers\UserController::class, 'updateBanner']); // 🔹

    Route::put('user/update', [\Modules\User\Http\Controllers\UserController::class, 'update']);
    Route::get('user/me', [\Modules\User\Http\Controllers\UserController::class, 'me']);

});

Route::get('agency/{id}', [\Modules\User\Http\Controllers\AgencyController::class, 'details']);
Route::get('agency/make-premium/{id}', [\Modules\User\Http\Controllers\AgencyController::class, 'makePremium']);
Route::get('agency', [\Modules\User\Http\Controllers\AgencyController::class, 'index']);

