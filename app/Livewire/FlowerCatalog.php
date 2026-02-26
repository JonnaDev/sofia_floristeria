<?php

namespace App\Livewire;

use App\Models\Flower;
use App\Models\Category;
use Livewire\Component;

class FlowerCatalog extends Component
{
    public $flowers;
    public $categories;
    public $selectedCategory = null;
    public $search = '';
    public $perPage = 10;
    public $loadedCount = 10;
    public $hasMore = true;
    public $cartCount = 0;
    public $cartMessage = '';

    public function mount()
    {
        $this->categories = Category::withCount('flowers')
            ->having('flowers_count', '>', 0)
            ->orderBy('name')
            ->get();

        if (request('category_id')) {
            $this->selectedCategory = (int) request('category_id');
        }

        $this->cartCount = count(session('cart', []));
        $this->loadFlowers();
    }

    public function addToCart($flowerId)
    {
        $flower = Flower::find($flowerId);

        if (!$flower || $flower->stock <= 0) {
            $this->cartMessage = 'Este producto no tiene stock disponible.';
            return;
        }

        $cart = session('cart', []);

        if (isset($cart[$flowerId])) {
            if ($cart[$flowerId]['quantity'] < $flower->stock) {
                $cart[$flowerId]['quantity']++;
                $this->cartMessage = "'{$flower->name}' cantidad actualizada.";
            } else {
                $this->cartMessage = "Stock máximo alcanzado para '{$flower->name}'.";
                session(['cart' => $cart]);
                $this->cartCount = count($cart);
                return;
            }
        } else {
            $cart[$flowerId] = [
                'id'       => $flower->id,
                'name'     => $flower->name,
                'price'    => $flower->price,
                'quantity' => 1,
                'stock'    => $flower->stock,
                'photo'    => $flower->photo_flower_url,
            ];
            $this->cartMessage = "'{$flower->name}' agregado al carrito.";
        }

        session(['cart' => $cart]);
        $this->cartCount = count($cart);
    }

    public function loadFlowers()
    {
        $query = Flower::with('categories')
            ->where('stock', '>', 0);

        // Filtro por categoría
        if ($this->selectedCategory) {
            $query->whereHas('categories', function($q) {
                $q->where('category_id', $this->selectedCategory);
            });
        }

        // Filtro de búsqueda
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        $this->flowers = $query->orderBy('id', 'desc')
            ->take($this->loadedCount)
            ->get();

        // Verificar si hay más flores
        $totalCount = $query->count();
        $this->hasMore = $this->loadedCount < $totalCount;
    }

    public function loadMore()
    {
        $this->loadedCount += $this->perPage;
        $this->loadFlowers();
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId == $this->selectedCategory ? null : $categoryId;
        $this->loadedCount = $this->perPage;
        $this->loadFlowers();
    }

    public function updatedSearch()
    {
        $this->loadedCount = $this->perPage;
        $this->loadFlowers();
    }

    public function updatedPerPage()
    {
        $this->loadedCount = $this->perPage;
        $this->loadFlowers();
    }

    public function clearFilters()
    {
        $this->selectedCategory = null;
        $this->search = '';
        $this->loadedCount = $this->perPage;
        $this->loadFlowers();
    }

    public function render()
    {
        return view('livewire.flower-catalog');
    }
}
