<?php

use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestockController;
use App\Models\Flower;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $flowers = Flower::with('categories')->orderBy('id', 'desc')->limit(6)->get();
    return view('welcome', compact('flowers'));
})->name('home');

Route::get('/catalogo', function () {
    return view('catalog');
})->name('catalog');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('flowers', FlowerController::class);
    Route::resource('categories', CategoryController::class);

    // Rutas de reabastecimiento
    Route::get('restocks', [RestockController::class, 'index'])->name('restocks.index');
    Route::get('restocks/history', [RestockController::class, 'history'])->name('restocks.history');
    Route::get('restocks/{flower}/create', [RestockController::class, 'create'])->name('restocks.create');
    Route::post('restocks/{flower}', [RestockController::class, 'store'])->name('restocks.store');
});

require __DIR__.'/settings.php';
