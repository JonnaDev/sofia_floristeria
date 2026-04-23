<?php

namespace App\Support;

use App\Models\Flower;

class Cart
{
    private const SESSION_KEY = 'cart';

    public static function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public static function count(): int
    {
        return count(self::all());
    }

    public static function total(): int
    {
        return collect(self::all())->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    public static function add(int $flowerId): string
    {
        $flower = Flower::find($flowerId);

        if (! $flower || $flower->stock <= 0) {
            return 'Este producto no tiene stock disponible.';
        }

        $cart = self::all();

        if (isset($cart[$flowerId])) {
            if ($cart[$flowerId]['quantity'] >= $flower->stock) {
                self::persist($cart);
                return "Stock máximo alcanzado para '{$flower->name}'.";
            }
            $cart[$flowerId]['quantity']++;
            $message = "'{$flower->name}' cantidad actualizada.";
        } else {
            $cart[$flowerId] = [
                'id'       => $flower->id,
                'name'     => $flower->name,
                'price'    => $flower->price,
                'quantity' => 1,
                'stock'    => $flower->stock,
                'photo'    => $flower->photo_flower_url,
            ];
            $message = "'{$flower->name}' agregado al carrito.";
        }

        self::persist($cart);

        return $message;
    }

    public static function increment(int $flowerId): void
    {
        $cart = self::all();
        if (! isset($cart[$flowerId])) {
            return;
        }
        if ($cart[$flowerId]['quantity'] < $cart[$flowerId]['stock']) {
            $cart[$flowerId]['quantity']++;
            self::persist($cart);
        }
    }

    public static function decrement(int $flowerId): void
    {
        $cart = self::all();
        if (! isset($cart[$flowerId])) {
            return;
        }
        if ($cart[$flowerId]['quantity'] <= 1) {
            unset($cart[$flowerId]);
        } else {
            $cart[$flowerId]['quantity']--;
        }
        self::persist($cart);
    }

    public static function remove(int $flowerId): void
    {
        $cart = self::all();
        unset($cart[$flowerId]);
        self::persist($cart);
    }

    public static function clear(): void
    {
        self::persist([]);
    }

    public static function whatsappUrl(string $phone = '573177261647'): string
    {
        $cart = self::all();
        if (empty($cart)) {
            return '';
        }

        $message = "¡Hola! Quiero hacer un pedido desde la web:\n" . url('/') . " 🌸\n\n📋 *Mi Pedido:*\n";

        foreach ($cart as $item) {
            $sub   = number_format($item['price'] * $item['quantity'], 0, ',', '.');
            $price = number_format($item['price'], 0, ',', '.');
            $message .= "• {$item['quantity']}x {$item['name']} - \${$price} c/u = \${$sub}\n";
        }

        $total    = number_format(self::total(), 0, ',', '.');
        $message .= "\n💰 *Total: \${$total}*\n\nPor favor confirmar disponibilidad y datos de entrega.";

        return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
    }

    private static function persist(array $cart): void
    {
        session([self::SESSION_KEY => $cart]);
    }
}
