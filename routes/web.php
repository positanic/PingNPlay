<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PickupGameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PickupGameController::class, 'index'])->name('calendar');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Game display route
    Route::get('/game/{id}', [PickupGameController::class, 'show'])->name('game');
    // Game signup actions
    Route::post('/game/{id}/signup', [PickupGameController::class, 'signup'])->name('game.signup');
    Route::patch('/game/{id}/signup', [PickupGameController::class, 'updateSignup'])->name('game.signup.update');
    Route::delete('/game/{id}/signup', [PickupGameController::class, 'cancelSignup'])->name('game.signup.cancel');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/pickup-games', [App\Http\Controllers\PickupGameController::class, 'store'])
        ->name('pickup-games.store');
});

Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');

require __DIR__.'/auth.php';
