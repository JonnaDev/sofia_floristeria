<div class="min-h-screen bg-gray-50">
    <!-- Barra de búsqueda y filtros -->
    <div class="bg-white shadow-sm border-b sticky top-16 z-40">
        <div class="container mx-auto px-4 py-4">
            <!-- Barra de búsqueda -->
            <div class="mb-4">
                <div class="relative max-w-2xl mx-auto">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar productos..."
                        class="w-full px-4 py-3 pl-12 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Filtros de categorías -->
            <div class="flex flex-wrap gap-2 mb-4">
                <button
                    wire:click="filterByCategory(null)"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition {{ !$selectedCategory ? 'bg-pink-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Todos
                </button>
                @foreach($categories as $category)
                    <button
                        wire:click="filterByCategory({{ $category->id }})"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $selectedCategory == $category->id ? 'bg-pink-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $category->name }}
                        <span class="ml-1 text-xs opacity-75">({{ $category->flowers_count }})</span>
                    </button>
                @endforeach
            </div>

            <!-- Controles: Mostrar y Limpiar -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <label class="text-sm text-gray-600 font-medium">Mostrar:</label>
                    <select
                        wire:model.live="perPage"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                @if($selectedCategory || $search)
                    <button
                        wire:click="clearFilters"
                        class="text-sm text-pink-600 hover:text-pink-700 font-semibold">
                        Limpiar filtros
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Grid de flores -->
    <div class="container mx-auto px-4 py-8">
        @if($flowers->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 fade-in-up">
                @foreach($flowers as $flower)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Imagen clickeable para expandir -->
                        <div class="h-64 bg-ambar-500 flex items-center justify-center overflow-hidden relative cursor-pointer group"
                             onclick="openImageModal(this)"
                             data-image="{{ $flower->photo_flower_url ? asset('storage/' . $flower->photo_flower_url) : '' }}">
                            @if($flower->photo_flower_url)
                                <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                                     alt="{{ $flower->name }}"
                                     class="w-md h-md object-cover">
                                <!-- Overlay con icono de expandir -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            @else
                                <svg class="w-24 h-24 text-pink-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                </svg>
                            @endif

                            @if($flower->stock > 0)
                                <span class="absolute top-3 left-3 bg-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    Disponible
                                </span>
                            @else
                                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    Agotado
                                </span>
                            @endif
                        </div>

                        <!-- Contenido -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1">{{ $flower->name }}</h3>

                            @if($flower->description)
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $flower->description }}</p>
                            @endif

                            <!-- Categorías -->
                            @if($flower->categories->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach($flower->categories->take(3) as $category)
                                        <span class="text-xs bg-pink-100 text-pink-700 px-2 py-1 rounded-full">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Precio y stock -->
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-pink-600">
                                    ${{ number_format($flower->price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Stock: {{ $flower->stock }}
                                </span>
                            </div>

                            <!-- Botón de contacto -->
                            <a href="https://wa.me/573177261647?text=Hola,%20me%20interesa%20{{ urlencode($flower->name) }}%20por%20${{ number_format($flower->price, 0, ',', '.') }}"
                               target="_blank"
                               class="mt-4 w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition text-center block font-semibold">
                                Pedir por WhatsApp
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Botón cargar más -->
            @if($hasMore)
                <div class="text-center mt-10">
                    <button
                        wire:click="loadMore"
                        class="bg-pink-600 text-white px-8 py-3 rounded-lg hover:bg-pink-700 transition font-semibold inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        Cargar más productos
                    </button>
                    <p class="text-sm text-gray-500 mt-2">
                        Mostrando {{ $flowers->count() }} productos
                    </p>
                </div>
            @else
                <p class="text-center text-gray-500 mt-8 text-sm">
                    Has visto todos los productos disponibles ({{ $flowers->count() }} en total)
                </p>
            @endif
        @else
            <!-- Sin resultados -->
            <div class="text-center py-20">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">No se encontraron productos</h3>
                <p class="text-gray-500 mb-6">Intenta cambiar los filtros o buscar otro término</p>
                <button
                    wire:click="clearFilters"
                    class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">
                    Ver todos los productos
                </button>
            </div>
        @endif
    </div>

    <!-- Modal para expandir SOLO la imagen -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4" onclick="closeImageModal(event)">
        <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
            <!-- Botón cerrar -->
            <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-pink-400 transition-colors duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Imagen expandida -->
            <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[85vh] object-contain rounded-lg shadow-2xl">

            <!-- Nombre del producto debajo -->
            <p id="modalName" class="text-white text-center mt-4 text-lg font-semibold"></p>
        </div>
    </div>

    <script>
        function openImageModal(element) {
            const imageUrl = element.dataset.image;


            if (!imageUrl) return;

            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
                const modalName = document.getElementById('modalName');

            modalImage.src = imageUrl;
            modalImage.alt = name;
            modalName.textContent = name;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal(event) {
            if (event && event.target !== event.currentTarget) return;

            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</div>
