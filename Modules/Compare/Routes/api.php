<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Base\Http\Controllers\EnumController;
use Modules\Base\Http\Controllers\SubwayController;

use Modules\Compare\Http\Controllers\CompareController;

Route::prefix('compare')->group(function () {
    Route::post('/', [CompareController::class, 'store']);   // Məhsul əlavə et
    Route::delete('/{id}', [CompareController::class, 'destroy']); // Məhsulu sil
    Route::get('/', [CompareController::class, 'index']);   // Seçilmişləri göstər
});