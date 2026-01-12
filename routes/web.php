<?php

use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CategoryController;
use App\Models\Flower;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $flowers = Flower::with('categories')->orderBy('id', 'desc')->limit(6)->get();
    return view('welcome', compact('flowers'));
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('flowers', FlowerController::class);
    Route::resource('categories', CategoryController::class);
});

require __DIR__.'/settings.php';
