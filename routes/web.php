<?php

use App\Http\Controllers\CertificatController;
use App\Http\Controllers\HabitantController;
use App\Http\Controllers\MaisonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\QuartierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('proprietaires', ProprietaireController::class)->only(['create', 'store']);
Route::resource('quartiers', QuartierController::class)->only(['index']);
Route::resource('maisons', MaisonController::class)->only(['index']);
Route::resource('habitants', HabitantController::class)->only(['create', 'store']);
Route::resource('certificats', CertificatController::class)->only(['create']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('proprietaires', ProprietaireController::class)->except(['create', 'store']);
    Route::resource('quartiers', QuartierController::class)->except(['index']);
    Route::resource('maisons', MaisonController::class)->except(['index']);
    Route::resource('habitants', HabitantController::class)->except(['create', 'store']);
    Route::resource('certificats', CertificatController::class)->only(['store', 'index']);
});

require __DIR__ . '/auth.php';
