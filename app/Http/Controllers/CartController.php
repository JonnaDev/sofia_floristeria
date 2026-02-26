<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Agrega una flor al carrito (route model binding resuelve el Flower).
     * Si ya existe en el carrito, incrementa la cantidad hasta el límite de stock.
     */
    public function add(Flower $flower)
    {
        if ($flower->stock <= 0) {
            return redirect()->route('catalog')->with('cart_error', "'{$flower->name}' no tiene stock disponible.");
        }

        $cart = session('cart', []);
        $id   = $flower->id;

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] < $flower->stock) {
                $cart[$id]['quantity']++;
            }
        } else {
            $cart[$id] = [
                'id'       => $flower->id,
                'name'     => $flower->name,
                'price'    => $flower->price,
                'quantity' => 1,
                'stock'    => $flower->stock,
                'photo'    => $flower->photo_flower_url,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('catalog')->with('cart_success', "'{$flower->name}' agregado al carrito con exito.");
    }
}
