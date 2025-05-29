<?php

use App\Http\Controllers\HabitantController;
use App\Http\Controllers\MaisonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\QuartierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('proprietaires', ProprietaireController::class);
Route::resource('quartiers', QuartierController::class);
Route::resource('maisons', MaisonController::class);
Route::resource('habitants', HabitantController::class);

require __DIR__.'/auth.php';
