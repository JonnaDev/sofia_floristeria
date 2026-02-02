<div class="min-h-screen bg-gray-50">
    <!-- Barra de búsqueda y filtros -->
    <div class="bg-white shadow-sm border-b sticky top-16 z-40">
        <div class="container mx-auto px-4 py-3 md:py-4">
            <!-- Barra de búsqueda -->
            <div class="mb-3 md:mb-4">
                <div class="relative max-w-2xl mx-auto">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar productos..."
                        class="w-full px-4 py-2.5 md:py-3 pl-10 md:pl-12 pr-4 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 absolute left-3 md:left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Filtros de categorías responsive -->
            <div class="mb-3 md:mb-4">
                <!-- Mobile: scroll horizontal con fade en bordes -->
                <div class="relative md:hidden">
                    <!-- Fade derecho -->
                    <div class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

                    <div id="categoryScroll" class="flex gap-2 overflow-x-auto pb-2" style="-webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;">
                        <button
                            wire:click="filterByCategory(null)"
                            class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition whitespace-nowrap
                                {{ !$selectedCategory 
                                    ? 'bg-pink-500 text-white shadow-sm' 
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Todos
                        </button>
                        @foreach($categories as $category)
                            <button
                                wire:click="filterByCategory({{ $category->id }})"
                                class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition whitespace-nowrap
                                    {{ $selectedCategory == $category->id 
                                        ? 'bg-pink-500 text-white shadow-sm shadow-pink-500/30' 
                                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Desktop: wrap normal -->
                <div class="hidden md:flex flex-wrap gap-2">
                    <button
                        wire:click="filterByCategory(null)"
                        class="px-4 py-2 rounded-full text-sm font-semibold transition
                            {{ !$selectedCategory 
                                ? 'bg-pink-500 text-white' 
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Todos
                    </button>
                    @foreach($categories as $category)
                        <button
                            wire:click="filterByCategory({{ $category->id }})"
                            class="px-4 py-2 rounded-full text-sm font-semibold transition
                                {{ $selectedCategory == $category->id 
                                    ? 'bg-pink-500 text-white shadow-md shadow-pink-500/30' 
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Controles: Mostrar y Limpiar -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 md:gap-3">
                    <label class="text-xs md:text-sm text-gray-500 font-medium">Mostrar:</label>
                    <select
                        wire:model.live="perPage"
                        class="px-2 md:px-3 py-1.5 md:py-2 border bg-pink-300/50 border-gray-200 rounded-lg text-xs md:text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                @if($selectedCategory || $search)
                    <button
                        wire:click="clearFilters"
                        class="text-xs md:text-sm text-pink-500 hover:text-pink-600 font-semibold transition">
                        Limpiar filtros
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Grid de flores -->
    <div class="container mx-auto px-4 py-6 md:py-8">
        @if($flowers->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-6">
                @foreach($flowers as $flower)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Imagen -->
                        <div class="h-40 md:h-64 bg-gray-100 flex items-center justify-center overflow-hidden relative cursor-pointer group"
                             onclick="openImageModal(this, '{{ $flower->name }}')"
                             data-image="{{ $flower->photo_flower_url ? asset('storage/' . $flower->photo_flower_url) : '' }}">
                            @if($flower->photo_flower_url)
                                <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                                     alt="{{ $flower->name }}"
                                     class="w-full h-full object-cover">
                                <!-- Overlay expandir -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                    <svg class="w-8 h-8 md:w-10 md:h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            @else
                                <svg class="w-16 h-16 md:w-24 md:h-24 text-pink-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                </svg>
                            @endif

                            <!-- Badge disponibilidad -->
                            @if($flower->stock > 0)
                                <span class="absolute top-2 left-2 md:top-3 md:left-3 bg-pink-500 text-white text-xs font-bold px-2 md:px-3 py-0.5 md:py-1 rounded-full">
                                    Disponible
                                </span>
                            @else
                                <span class="absolute top-2 left-2 md:top-3 md:left-3 bg-red-500 text-white text-xs font-bold px-2 md:px-3 py-0.5 md:py-1 rounded-full">
                                    Agotado
                                </span>
                            @endif
                        </div>

                        <!-- Contenido -->
                        <div class="p-3 md:p-5">
                            <h3 class="text-sm md:text-lg font-bold text-gray-800 mb-1 md:mb-2 line-clamp-1">{{ $flower->name }}</h3>

                            <!-- Descripción solo en desktop -->
                            @if($flower->description)
                                <p class="hidden md:block text-sm text-gray-500 mb-3 line-clamp-2">{{ $flower->description }}</p>
                            @endif

                            <!-- Categorías -->
                            @if($flower->categories->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-2 md:mb-3">
                                    @foreach($flower->categories->take(2) as $category)
                                        <span class="text-xs bg-pink-50 text-pink-600 px-2 py-0.5 rounded-full font-medium">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                    @if($flower->categories->count() > 2)
                                        <span class="text-xs text-gray-400">+{{ $flower->categories->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif

                            <!-- Precio y stock -->
                            <div class="flex justify-between items-center">
                                <span class="text-base md:text-xl font-bold text-pink-600">
                                    ${{ number_format($flower->price, 0, ',', '.') }}
                                </span>
                                <span class="text-xs md:text-sm text-gray-500 font-medium">
                                    Stock: {{ $flower->stock }}
                                </span>
                            </div>

                            <!-- Botón WhatsApp -->
                            <a href="https://wa.me/573177261647?text=Hola,%20nuevo%20pedido%20desde%20la%20web%20{{ urlencode(url('/')) }}%0A%0AMe%20interesa%20{{ urlencode($flower->name) }}%20por%20${{ number_format($flower->price, 0, ',', '.') }}"
                               target="_blank"
                               class="mt-3 md:mt-4 w-full bg-green-500 text-white py-2 md:py-2.5 rounded-lg hover:bg-green-600 transition text-center block text-xs md:text-sm font-semibold">
                                Pedir por WhatsApp
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Cargar más -->
            @if($hasMore)
                <div class="text-center mt-8 md:mt-10">
                    <button
                        wire:click="loadMore"
                        class="bg-pink-500 text-white px-6 md:px-8 py-2.5 md:py-3 rounded-lg hover:bg-pink-600 transition font-semibold inline-flex items-center gap-2 text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        Cargar más
                    </button>
                    <p class="text-xs md:text-sm text-gray-400 mt-2">
                        Mostrando {{ $flowers->count() }} productos
                    </p>
                </div>
            @else
                <p class="text-center text-gray-400 mt-6 md:mt-8 text-xs md:text-sm">
                    Todos los productos disponibles ({{ $flowers->count() }} en total)
                </p>
            @endif
        @else
            <!-- Sin resultados -->
            <div class="text-center py-16 md:py-20">
                <svg class="w-20 h-20 md:w-24 md:h-24 text-gray-300 mx-auto mb-4 md:mb-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                </svg>
                <h3 class="text-xl md:text-2xl font-bold text-gray-700 mb-2 md:mb-3">No se encontraron productos</h3>
                <p class="text-gray-500 mb-4 md:mb-6 text-sm">Intenta cambiar los filtros o buscar otro término</p>
                <button
                    wire:click="clearFilters"
                    class="bg-pink-500 text-white px-5 md:px-6 py-2 md:py-2.5 rounded-lg hover:bg-pink-600 transition font-semibold text-sm">
                    Ver todos los productos
                </button>
            </div>
        @endif
    </div>

    <!-- Modal imagen -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4" onclick="closeImageModal(event)">
        <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
            <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-pink-400 transition-colors duration-300">
                <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg shadow-2xl">
            <p id="modalName" class="text-white text-center mt-3 text-sm md:text-lg font-semibold"></p>
        </div>
    </div>

    <script>
        function openImageModal(element, name) {
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

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</div>