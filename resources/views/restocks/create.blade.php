<x-layouts.app :title="__('Reabastecer Stock')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-8 max-w-3xl mx-auto w-full">

            <div class="mb-6">
                <a href="{{ route('restocks.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    ← Volver a flores a reabastecer
                </a>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Reabastecer Stock de Flor</h1>

            {{-- Información de la flor --}}
            <div class="bg-gradient-to-br from-pink-50 to-purple-50 dark:from-pink-900/10 dark:to-purple-900/10 rounded-xl p-6 mb-8 border border-pink-200 dark:border-pink-800">
                <div class="flex items-start gap-6">
                    @if($flower->photo_flower_url)
                        <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                             alt="{{ $flower->name }}"
                             class="w-32 h-32 object-cover rounded-lg shadow-lg">
                    @else
                        <div class="w-32 h-32 bg-gradient-to-br from-pink-200 to-purple-200 rounded-lg flex items-center justify-center">
                            <svg class="w-16 h-16 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $flower->name }}</h2>

                        @if($flower->categories->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($flower->categories as $category)
                                    <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Precio Unitario</p>
                                <p class="text-xl font-bold text-pink-600 dark:text-pink-400">${{ number_format($flower->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Stock Actual</p>
                                <p class="text-xl font-bold
                                    @if($flower->stock == 0) text-red-600 dark:text-red-400
                                    @elseif($flower->stock <= 2) text-orange-600 dark:text-orange-400
                                    @else text-yellow-600 dark:text-yellow-400
                                    @endif">
                                    {{ $flower->stock }} unidades
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
                    <strong class="font-bold">¡Oops! Hay algunos errores:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('restocks.store', $flower) }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="added_quantity" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                        Cantidad a Agregar <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="added_quantity"
                           id="added_quantity"
                           value="{{ old('added_quantity', 10) }}"
                           min="1"
                           max="1000"
                           class="w-full px-4 py-3 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-lg font-semibold @error('added_quantity') border-red-500 @enderror"
                           placeholder="Ej: 50"
                           onchange="updatePreview()">
                    @error('added_quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Cantidad de unidades a agregar al inventario (entre 1 y 1000)</p>
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                        Notas (Opcional)
                    </label>
                    <textarea name="notes"
                              id="notes"
                              rows="3"
                              class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('notes') border-red-500 @enderror"
                              placeholder="Ej: Proveedor XYZ, pedido #12345, fecha de entrega...">{{ old('notes') }}</textarea>
                    @error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Información adicional sobre este reabastecimiento (máximo 500 caracteres)</p>
                </div>

                {{-- Preview del resultado --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-blue-900 dark:text-blue-300 mb-4">Vista Previa del Reabastecimiento</h3>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Stock Anterior</p>
                            <p class="text-2xl font-bold text-gray-700 dark:text-gray-300" id="preview-previous">{{ $flower->stock }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Se Agregan</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400" id="preview-added">+10</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Nuevo Stock</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400" id="preview-new">{{ $flower->stock + 10 }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold text-lg">
                        Confirmar Reabastecimiento
                    </button>
                    <a href="{{ route('restocks.index') }}" class="bg-gray-300 dark:bg-zinc-700 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-lg hover:bg-gray-400 dark:hover:bg-zinc-600 transition font-semibold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const currentStock = {{ $flower->stock }};

        function updatePreview() {
            const addedQuantity = parseInt(document.getElementById('added_quantity').value) || 0;
            const newStock = currentStock + addedQuantity;

            document.getElementById('preview-previous').textContent = currentStock;
            document.getElementById('preview-added').textContent = '+' + addedQuantity;
            document.getElementById('preview-new').textContent = newStock;
        }

        // Initialize preview on page load
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
        });
    </script>
    @endpush
</x-layouts.app>
