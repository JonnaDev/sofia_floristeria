<div class="min-h-screen bg-gray-100">

    <!-- Toast de confirmación del carrito -->
    @if($cartMessage)
    <div id="cart-toast"
         class="fixed bottom-4 right-4 z-50 bg-pink-600 text-white px-5 py-3 rounded-xl shadow-2xl text-sm font-semibold flex items-center gap-3 max-w-xs"
         x-data="{ show: true }" x-show="show" x-transition
         style="animation: fadeInUp 0.3s ease-out;">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span>{{ $cartMessage }}</span>
        <a href="{{ route('cart') }}" class="underline ml-1 font-bold whitespace-nowrap">Ver carrito →</a>
    </div>
    @endif

    <!-- Barra de búsqueda y filtros (sticky, colapsa al hacer scroll down) -->
    <div id="catalog-filterbar" class="bg-white shadow-sm border-b sticky top-16 z-40">
        <div class="container mx-auto px-4 pt-3 pb-0">

            <!-- Fila siempre visible: búsqueda + botón filtros (colapsado) + carrito -->
            <div class="flex items-center gap-2 mb-3">

                <!-- Input búsqueda -->
                <div class="relative flex-1">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar productos..."
                        class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Botón "Filtros" — siempre visible, toggle manual -->
                <button id="filters-toggle-btn"
                        onclick="toggleFilters()"
                        class="flex items-center gap-1.5 px-3 py-2.5 border border-gray-200 rounded-lg text-xs font-semibold text-gray-600 hover:border-pink-400 hover:text-pink-500 transition flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filtros
                    @if($selectedCategory)
                        <span class="bg-pink-500 text-white rounded-full w-4 h-4 inline-flex items-center justify-center leading-none">1</span>
                    @endif
                </button>

                <!-- Carrito badge (siempre visible) -->
                @if($cartCount > 0)
                    <a href="{{ route('cart') }}"
                       class="flex items-center gap-1.5 bg-pink-500 text-white px-3 py-2.5 rounded-lg text-xs font-bold hover:bg-pink-600 transition flex-shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:inline">Carrito</span> ({{ $cartCount }})
                    </a>
                @endif
            </div>

            <!-- Panel colapsable: categorías + controles -->
            <div id="filter-collapsible"
                 style="overflow:hidden; max-height:300px; opacity:1; transition: max-height 0.3s ease-out, opacity 0.25s ease-out;">

                <!-- Categorías -->
                <div class="mb-2">
                    <!-- Mobile: scroll horizontal -->
                    <div class="relative md:hidden">
                        <div class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
                        <div class="flex gap-2 overflow-x-auto pb-2" style="-webkit-overflow-scrolling:touch; scrollbar-width:none; -ms-overflow-style:none;">
                            <button wire:click="filterByCategory(null)"
                                    class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition whitespace-nowrap
                                        {{ !$selectedCategory ? 'bg-pink-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                Todos
                            </button>
                            @foreach($categories as $category)
                                <button wire:click="filterByCategory({{ $category->id }})"
                                        class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition whitespace-nowrap
                                            {{ $selectedCategory == $category->id ? 'bg-pink-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Desktop: pills en fila con wrap -->
                    <div class="hidden md:flex flex-wrap gap-2">
                        <button wire:click="filterByCategory(null)"
                                class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                                    {{ !$selectedCategory ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Todos
                        </button>
                        @foreach($categories as $category)
                            <button wire:click="filterByCategory({{ $category->id }})"
                                    class="px-4 py-1.5 rounded-full text-sm font-semibold transition
                                        {{ $selectedCategory == $category->id ? 'bg-pink-500 text-white shadow-md shadow-pink-500/30' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Controles: Mostrar + Limpiar -->
                <div class="flex items-center justify-between pb-3">
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 font-medium">Mostrar:</label>
                        <select wire:model.live="perPage"
                                class="px-2 py-1.5 border bg-pink-100 border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-pink-400">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    @if($selectedCategory || $search)
                        <button wire:click="clearFilters"
                                class="text-xs text-pink-500 hover:text-pink-600 font-semibold transition">
                            × Limpiar filtros
                        </button>
                    @endif
                </div>
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

                            <!-- Botones: carrito + WhatsApp -->
                            <div class="mt-3 md:mt-4 flex flex-col gap-2">
                                <button
                                    wire:click="addToCart({{ $flower->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="addToCart({{ $flower->id }})"
                                    @if($flower->stock <= 0) disabled @endif
                                    class="w-full bg-pink-500 text-white py-2 md:py-2.5 rounded-lg hover:bg-pink-600 transition text-xs md:text-sm font-semibold flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-4 h-4 flex-shrink-0" wire:loading.remove wire:target="addToCart({{ $flower->id }})" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span wire:loading.remove wire:target="addToCart({{ $flower->id }})">Agregar al carrito</span>
                                    <span wire:loading wire:target="addToCart({{ $flower->id }})">Agregando...</span>
                                </button>
                                <a href="https://wa.me/573177261647?text=Hola,%20nuevo%20pedido%20desde%20la%20web%20{{ urlencode(url('/')) }}%0A%0AMe%20interesa%20{{ urlencode($flower->name) }}%20por%20${{ number_format($flower->price, 0, ',', '.') }}"
                                   target="_blank"
                                   class="w-full bg-green-500 text-white py-1.5 md:py-2 rounded-lg hover:bg-green-600 transition text-center block text-xs font-medium">
                                    Pedir por WhatsApp
                                </a>
                            </div>
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

        // ── Colapsar filtros al hacer scroll down / expandir solo con botón ───
        (function () {
            const collapsible = document.getElementById('filter-collapsible');
            let lastScrollY   = window.scrollY;
            let filtersOpen   = true;
            let ticking       = false;

            function collapseFilters() {
                collapsible.style.maxHeight = '0px';
                collapsible.style.opacity   = '0';
                filtersOpen = false;
            }

            function expandFilters() {
                collapsible.style.maxHeight = '300px';
                collapsible.style.opacity   = '1';
                filtersOpen = true;
            }

            // Solo el botón abre/cierra — nunca auto-expande al subir
            window.toggleFilters = function () {
                filtersOpen ? collapseFilters() : expandFilters();
            };

            window.addEventListener('scroll', function () {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(function () {
                    const currentY = window.scrollY;
                    if (currentY > 80 && currentY > lastScrollY && filtersOpen) {
                        collapseFilters();
                    }
                    lastScrollY = currentY;
                    ticking = false;
                });
            }, { passive: true });
        })();
    </script>
</div>