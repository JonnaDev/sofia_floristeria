<?php

use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\CartController;
use App\Models\Flower;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $flowers = Flower::with('categories')
    ->where('price', '>=', 150000)
    ->orderBy('id', 'desc')
    ->limit(6)
    ->get();
    return view('welcome', compact('flowers'));
})->name('home');

Route::get('/catalogo', function () {
    return view('catalog');
})->name('catalog');

// Carrito de compras (público, sin autenticación)
Route::get('/carrito', [CartController::class, 'index'])->name('cart');
Route::post('/carrito/agregar/{flower}', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/actualizar/{flowerId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/carrito/eliminar/{flowerId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/carrito/vaciar', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/dashboard', [FlowerController::class, 'indexDashboard'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');


    // Rutas protegidas por autenticación y solo para Admin
    Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('flowers', FlowerController::class);
    Route::resource('categories', CategoryController::class);

    // Rutas de reabastecimiento
    Route::get('restocks', [RestockController::class, 'index'])->name('restocks.index');
    Route::get('restocks/history', [RestockController::class, 'history'])->name('restocks.history');
    Route::get('restocks/{flower}/create', [RestockController::class, 'create'])->name('restocks.create');
    Route::post('restocks/{flower}', [RestockController::class, 'store'])->name('restocks.store');
});

require __DIR__.'/settings.php';
