<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [GameController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Games
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

    // Platforms
    Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms.index');
    Route::post('/platforms', [PlatformController::class, 'store'])->name('platforms.store');
    Route::put('/platforms/{platform}', [PlatformController::class, 'update'])->name('platforms.update');
    Route::delete('/platforms/{platform}', [PlatformController::class, 'destroy'])->name('platforms.destroy');
});

require __DIR__.'/settings.php';
