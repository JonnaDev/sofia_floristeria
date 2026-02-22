<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlowerRequest;
use App\Http\Requests\UpdateFlowerRequest;
use App\Models\Flower;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;


class FlowerController extends Controller
{

    public function welcomeFlower()
    {
        $flowers = Flower::with('categories')
        ->whereHas('categories', function ($query) {
        $query->whereIn('name', ['Bouquet de Rosas', 'Bouquet de Girasoles']);})
        ->where('stock', '>', 0)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();
    return view('welcome', compact('flowers'));
    }

    public function indexDashboard()
    {
        $flowersCount    = Flower::count();
        $categoriesCount = Category::count();
        $usersCount      = User::count();
    
        return view('dashboard', compact(
            'flowersCount',
            'categoriesCount',
            'usersCount'
        ));
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Flower::with('categories');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Busqueda por ID en %search% para formato mas rapido.
                if (is_numeric($search)) {
                    $q->orWhere('id', (int) $search);
                }
                else {
                $q->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%");
                    } 
                });
        }

        $data = $query
            ->orderBy('id', 'asc') 
            ->paginate(9)
            ->withQueryString();

        return view('flowers.index', compact('data'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('flowers.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlowerRequest $request)
    {

        // Obtener solo datos validados
        $validated = $request->validated();

        // Manejar la subida de imagen
        $photoPath = null;
        if ($request->hasFile('photo_flower_url')) {
            // Guardar en storage/app/public/flowers
            $photoPath = $request->file('photo_flower_url')->store('flowers', 'public');
        }

        // Crear la flor
        $flower = Flower::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'stock' => $validated['stock'],
            'photo_flower_url' => $photoPath,
        ]);

        // Asociar categorías

        $flower->categories()->attach($validated['category_ids']);

        // Redirigir con mensaje de éxito
        return redirect()->route('flowers.index')
                         ->with('success', 'Flor creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(flower $flower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flower $flower)
    {
        $categories = Category::all();
        $flower->load('categories');
        return view('flowers.edit', compact('flower', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlowerRequest $request, Flower $flower)
    {
        $validated = $request->validated();

        // Manejar imagen si se sube una nueva
        $photoPath = $flower->photo_flower_url;
        if ($request->hasFile('photo_flower_url')) {
            // Eliminar imagen anterior si existe
            if ($photoPath && \Storage::disk('public')->exists($photoPath)) {
                \Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo_flower_url')->store('flowers', 'public');
        }

        // Actualizar la flor
        $flower->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'stock' => $validated['stock'],
            'photo_flower_url' => $photoPath,
        ]);

        // Sincronizar categorías
        $flower->categories()->sync($validated['category_ids']);

        return redirect()->route('flowers.index')
                         ->with('success', 'Flor actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flower $flower)
    {
        // Eliminar imagen si existe
        if ($flower->photo_flower_url && \Storage::disk('public')->exists($flower->photo_flower_url)) {
            \Storage::disk('public')->delete($flower->photo_flower_url);
        }

        $flower->delete();

        return redirect()->route('flowers.index')
                         ->with('success', 'Flor eliminada exitosamente.');
    }
}
