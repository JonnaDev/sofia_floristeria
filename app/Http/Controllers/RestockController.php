<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use App\Models\Restock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestockController extends Controller
{
    /**
     * Mostrar flores con stock bajo (<=5) que necesitan reabastecimiento
     */
    public function index()
    {
        $flowers = Flower::with('categories')
                         ->where('stock', '<=', 5)
                         ->orderBy('stock', 'asc')
                         ->paginate(10);

        return view('restocks.index', compact('flowers'));
    }

    /**
     * Mostrar formulario para reabastecer una flor específica
     */
    public function create(Flower $flower)
    {
        return view('restocks.create', compact('flower'));
    }

    /**
     * Procesar el reabastecimiento de una flor
     */
    public function store(Request $request, Flower $flower)
    {
        $validated = $request->validate([
            'added_quantity' => 'required|integer|min:1|max:1000',
            'notes' => 'nullable|string|max:500',
        ], [
            'added_quantity.required' => 'La cantidad a agregar es obligatoria.',
            'added_quantity.integer' => 'La cantidad debe ser un número entero.',
            'added_quantity.min' => 'La cantidad mínima es 1.',
            'added_quantity.max' => 'La cantidad máxima es 1000.',
            'notes.max' => 'Las notas no pueden exceder 500 caracteres.',
        ]);

        DB::transaction(function () use ($flower, $validated) {
            $previousStock = $flower->stock;
            $addedQuantity = $validated['added_quantity'];
            $newStock = $previousStock + $addedQuantity;

            // Actualizar stock de la flor
            $flower->update(['stock' => $newStock]);

            // Registrar el reabastecimiento
            Restock::create([
                'flower_id' => $flower->id,
                'user_id' => Auth::id(),
                'previous_stock' => $previousStock,
                'added_quantity' => $addedQuantity,
                'new_stock' => $newStock,
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('restocks.index')
                         ->with('success', "Se reabastecieron {$validated['added_quantity']} unidades de {$flower->name}. Nuevo stock: " . $flower->fresh()->stock);
    }

    /**
     * Mostrar historial de todos los reabastecimientos
     */
    public function history()
    {
        $restocks = Restock::with(['flower', 'user'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(15);

        return view('restocks.history', compact('restocks'));
    }
}
