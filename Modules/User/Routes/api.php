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
//    Route::post('logout', 'logout');
});

//Route::middleware('auth:api')->group(function () {
//    Route::resource('/user', \Modules\User\Http\Controllers\UserController::class);
//});

