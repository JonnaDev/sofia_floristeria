<?php

use App\Http\Controllers\FlowerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestockController;
use App\Models\Flower;
use Illuminate\Support\Facades\Route;

Route::get('/', [FlowerController::class, 'welcomeFlower'])
->name('home');

Route::get('/catalogo', function () { 
    return view('catalog');
})->name('catalog');

// Carrito de compras — toda la lógica vive en App\Livewire\Cart (servicio: App\Support\Cart)
Route::get('/carrito', fn() => view('cart'))->name('cart');

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
