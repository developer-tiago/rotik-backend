<?php

use App\Http\Controllers\ActiveController;
use App\Http\Controllers\Auth;
use App\Http\Controllers\EvolutionOfHeritageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [Auth::class, 'register']);

Route::prefix('/auth')->group(function () {
    Route::post('/', [Auth::class, 'auth']);
    Route::get('/verify', [Auth::class, 'verify']);
});

Route::prefix('/actives')->group(function () {
    Route::get('/', [ActiveController::class, 'paginate']);
    Route::get('/{nameOrTicker}', [ActiveController::class, 'getActiveByNameOrTicker']);
});

Route::prefix('/evolutions-of-heritage')->group(function () {
   Route::get('/{userId}', [EvolutionOfHeritageController::class, 'getEvolutionByUser']);
});

Route::prefix('/transactions')->group(function () {
    Route::get('/{userId}', [TransactionController::class, 'index']);
    Route::get('/filter/{userId}', [TransactionController::class, 'getByCategory']);
    Route::post('/', [TransactionController::class, 'makeTransaction']);
});

Route::prefix('/wallet')->group(function () {
    Route::get('/{userId}', [WalletController::class, 'getActivesByUserId']);
    Route::get('/distribution/{userId}', [WalletController::class, 'index']);
});
