<?php

use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\CartController;
use App\Models\Flower;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $flowers = Flower::with('categories')
        ->whereHas('categories', function ($query) {
            $query->whereIn('name', ['Bouquet de Rosas', 'Bouquet de Girasoles']);
        })
        ->where('stock', '>', 0)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();
    return view('welcome', compact('flowers'));
})->name('home');

Route::get('/catalogo', function () {
    return view('catalog');
})->name('catalog');

// Carrito de compras — la lógica es manejada por App\Livewire\CartController
Route::get('/carrito', fn() => view('cart'))->name('cart');
// Agregar al carrito sigue siendo un POST clásico desde el catálogo
Route::post('/carrito/agregar/{flower}', [CartController::class, 'add'])->name('cart.add');

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
