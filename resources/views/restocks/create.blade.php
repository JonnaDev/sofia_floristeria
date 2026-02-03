<x-layouts.app :title="__('Reabastecer Stock')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-700 p-4 md:p-8 max-w-3xl mx-auto w-full">

            <div class="mb-4 md:mb-6">
                <a href="{{ route('restocks.index') }}" class="text-pink-600 dark:text-pink-400 hover:underline text-sm md:text-base">
                    ← Volver a flores a reabastecer
                </a>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-4 md:mb-6">Reabastecer Stock</h1>

            {{-- Info de la flor --}}
            <div class="bg-gradient-to-br from-pink-50 to-purple-50 dark:from-pink-900/10 dark:to-purple-900/10 rounded-xl p-4 md:p-6 mb-6 md:mb-8 border border-pink-200 dark:border-pink-800">
                <div class="flex flex-col sm:flex-row items-start gap-4 md:gap-6">
                    @if($flower->photo_flower_url)
                        <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                             alt="{{ $flower->name }}"
                             class="w-full sm:w-24 md:w-32 h-48 sm:h-24 md:h-32 object-cover rounded-lg shadow-lg">
                    @else
                        <div class="w-full sm:w-24 md:w-32 h-48 sm:h-24 md:h-32 bg-gradient-to-br from-pink-200 to-purple-200 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 md:w-16 md:h-16 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                            </svg>
                        </div>
                    @endif

                    <div class="flex-1 w-full">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $flower->name }}</h2>

                        @if($flower->categories->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($flower->categories as $category)
                                    <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-full text-xs md:text-sm font-semibold">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-3 md:gap-4">
                            <div>
                                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Precio Unitario</p>
                                <p class="text-lg md:text-xl font-bold text-pink-600 dark:text-pink-400">${{ number_format($flower->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Stock Actual</p>
                                <p class="text-lg md:text-xl font-bold
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
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-4 md:mb-6">
                    <strong class="font-bold text-sm md:text-base">¡Oops! Hay algunos errores:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('restocks.store', $flower) }}" method="POST">
                @csrf

                <div class="mb-4 md:mb-6">
                    <label for="added_quantity" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2 text-sm md:text-base">
                        Cantidad a Agregar <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="added_quantity"
                           id="added_quantity"
                           value="{{ old('added_quantity', 10) }}"
                           min="1"
                           max="1000"
                           class="w-full px-4 py-2.5 md:py-3 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 text-base md:text-lg font-semibold @error('added_quantity') border-red-500 @enderror"
                           placeholder="Ej: 50"
                           onchange="updatePreview()">
                    @error('added_quantity')<p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1">Cantidad entre 1 y 1000 unidades</p>
                </div>

                <div class="mb-4 md:mb-6">
                    <label for="notes" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2 text-sm md:text-base">
                        Notas (Opcional)
                    </label>
                    <textarea name="notes"
                              id="notes"
                              rows="3"
                              class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm md:text-base @error('notes') border-red-500 @enderror"
                              placeholder="Ej: Proveedor XYZ, pedido #12345...">{{ old('notes') }}</textarea>
                    @error('notes')<p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>@enderror
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1">Máximo 500 caracteres</p>
                </div>

                {{-- Preview --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 md:p-6 mb-4 md:mb-6">
                    <h3 class="font-bold text-blue-900 dark:text-blue-300 mb-3 md:mb-4 text-sm md:text-base">Vista Previa del Reabastecimiento</h3>
                    <div class="grid grid-cols-3 gap-2 md:gap-4 text-center">
                        <div>
                            <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Anterior</p>
                            <p class="text-xl md:text-2xl font-bold text-gray-700 dark:text-gray-300" id="preview-previous">{{ $flower->stock }}</p>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Agregar</p>
                            <p class="text-xl md:text-2xl font-bold text-green-600 dark:text-green-400" id="preview-added">+10</p>
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">Nuevo</p>
                            <p class="text-2xl md:text-3xl font-bold text-blue-600 dark:text-blue-400" id="preview-new">{{ $flower->stock + 10 }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <button type="submit" class="flex-1 bg-green-500 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg hover:bg-green-600 transition font-semibold text-base md:text-lg">
                        Confirmar Reabastecimiento
                    </button>
                    <a href="{{ route('restocks.index') }}" class="flex-1 bg-gray-200 dark:bg-zinc-700 text-gray-700 dark:text-gray-200 px-4 md:px-6 py-2.5 md:py-3 rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-600 transition font-semibold text-center text-base md:text-lg">
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

        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();
        });
    </script>
    @endpush
</x-layouts.app>