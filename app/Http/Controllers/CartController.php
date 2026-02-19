<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Muestra la vista del carrito.
     * Lee session('cart'), calcula el total y genera la URL de WhatsApp.
     */
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $whatsappUrl = '';
        if (!empty($cart)) {
            $whatsappMessage = "¡Hola! Quiero hacer un pedido desde la web:\n" . url('/') . " 🌸\n\n📋 *Mi Pedido:*\n";
            foreach ($cart as $item) {
                $sub   = number_format($item['price'] * $item['quantity'], 0, ',', '.');
                $price = number_format($item['price'], 0, ',', '.');
                $whatsappMessage .= "• {$item['quantity']}x {$item['name']} - \${$price} c/u = \${$sub}\n";
            }
            $whatsappMessage .= "\n💰 *Total: $" . number_format($total, 0, ',', '.') . "*\n\nPor favor confirmar disponibilidad y datos de entrega.";
            $whatsappUrl = 'https://wa.me/573177261647?text=' . urlencode($whatsappMessage);
        }

        return view('cart', compact('cart', 'total', 'whatsappUrl'));
    }

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

    /**
     * Actualiza la cantidad de un ítem en el carrito.
     * Clampea entre 1 y el stock almacenado en sesión.
     */
    public function update(Request $request, $flowerId)
    {
        $cart     = session('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$flowerId])) {
            if ($quantity < 1) {
                unset($cart[$flowerId]);
            } else {
                $cart[$flowerId]['quantity'] = min($quantity, $cart[$flowerId]['stock']);
            }
        }

        session(['cart' => $cart]);
        return redirect()->route('cart');
    }

    /**
     * Elimina un ítem del carrito.
     */
    public function remove($flowerId)
    {
        $cart = session('cart', []);
        unset($cart[$flowerId]);
        session(['cart' => $cart]);
        return redirect()->route('cart');
    }

    /**
     * Vacía todo el carrito.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart');
    }
}
