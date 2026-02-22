<?php

namespace App\Livewire;

use App\Models\Flower;
use Livewire\Component;

class CartController extends Component
{
    public array $cart = [];

    public function mount(): void
    {
        $this->cart = session('cart', []);
    }

    public function add(int $flowerId): void
    {
        $flower = Flower::find($flowerId);

        if (!$flower || $flower->stock <= 0) {
            return;
        }

        if (isset($this->cart[$flowerId])) {
            if ($this->cart[$flowerId]['quantity'] < $flower->stock) {
                $this->cart[$flowerId]['quantity']++;
            }
        } else {
            $this->cart[$flowerId] = [
                'id'       => $flower->id,
                'name'     => $flower->name,
                'price'    => $flower->price,
                'quantity' => 1,
                'stock'    => $flower->stock,
                'photo'    => $flower->photo_flower_url,
            ];
        }

        $this->syncSession();
    }

    public function increment(int $flowerId): void
    {
        if (isset($this->cart[$flowerId]) && $this->cart[$flowerId]['quantity'] < $this->cart[$flowerId]['stock']) {
            $this->cart[$flowerId]['quantity']++;
            $this->syncSession();
        }
    }

    public function decrement(int $flowerId): void
    {
        if (!isset($this->cart[$flowerId])) {
            return;
        }

        if ($this->cart[$flowerId]['quantity'] <= 1) {
            $this->remove($flowerId);
        } else {
            $this->cart[$flowerId]['quantity']--;
            $this->syncSession();
        }
    }

    public function remove(int $flowerId): void
    {
        unset($this->cart[$flowerId]);
        $this->syncSession();
    }

    public function clear(): void
    {
        $this->cart = [];
        $this->syncSession();
    }

    public function getTotal(): int
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function getWhatsappUrl(): string
    {
        if (empty($this->cart)) {
            return '';
        }

        $message = "¡Hola! Quiero hacer un pedido desde la web:\n" . url('/') . " 🌸\n\n📋 *Mi Pedido:*\n";

        foreach ($this->cart as $item) {
            $sub   = number_format($item['price'] * $item['quantity'], 0, ',', '.');
            $price = number_format($item['price'], 0, ',', '.');
            $message .= "• {$item['quantity']}x {$item['name']} - \${$price} c/u = \${$sub}\n";
        }

        $total    = number_format($this->getTotal(), 0, ',', '.');
        $message .= "\n💰 *Total: \${$total}*\n\nPor favor confirmar disponibilidad y datos de entrega.";

        return 'https://wa.me/573177261647?text=' . urlencode($message);
    }

    private function syncSession(): void
    {
        session(['cart' => $this->cart]);
    }

    public function render()
    {
        return view('livewire.cart-component', [
            'total'        => $this->getTotal(),
            'whatsappUrl'  => $this->getWhatsappUrl(),
        ]);
    }
}
