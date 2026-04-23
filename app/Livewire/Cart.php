<?php

namespace App\Livewire;

use App\Support\Cart as CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public array $cart = [];

    public function mount(): void
    {
        $this->refresh();
    }

    #[On('cart-updated')]
    public function refresh(): void
    {
        $this->cart = CartService::all();
    }

    public function increment(int $flowerId): void
    {
        CartService::increment($flowerId);
        $this->refresh();
        $this->dispatch('cart-updated');
    }

    public function decrement(int $flowerId): void
    {
        CartService::decrement($flowerId);
        $this->refresh();
        $this->dispatch('cart-updated');
    }

    public function remove(int $flowerId): void
    {
        CartService::remove($flowerId);
        $this->refresh();
        $this->dispatch('cart-updated');
    }

    public function clear(): void
    {
        CartService::clear();
        $this->refresh();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart-component', [
            'total'       => CartService::total(),
            'whatsappUrl' => CartService::whatsappUrl(),
        ]);
    }
}
