<div class="catalog-root min-h-screen" x-data="{ showFilters: false }">

    <style>
        /* ── Paleta premium gris + pink accent ── */
        .catalog-root {
            background:
                linear-gradient(180deg, #f4f4f5 0%, #fafafa 40%, #f4f4f5 100%);
        }

        /* ── Reveal horizontal apple-style ─────────────────────────── */
        .flower-card {
            opacity: 0;
            transition: opacity 0.85s cubic-bezier(.2,.7,.3,1),
                        transform 0.85s cubic-bezier(.2,.7,.3,1);
            will-change: transform, opacity;
        }
        /* Móvil (2 cols): par → desde la izquierda, impar → desde la derecha */
        @media (max-width: 1023px) {
            .flower-card:nth-child(odd)  { transform: translateX(-60px); }
            .flower-card:nth-child(even) { transform: translateX( 60px); }
        }
        /* Desktop (4 cols): cols 1-2 desde la izquierda, cols 3-4 desde la derecha */
        @media (min-width: 1024px) {
            .flower-card:nth-child(4n+1),
            .flower-card:nth-child(4n+2) { transform: translateX(-70px); }
            .flower-card:nth-child(4n+3),
            .flower-card:nth-child(4n+4) { transform: translateX( 70px); }
        }
        .flower-card.is-revealed {
            opacity: 1;
            transform: translateX(0);
        }

        /* ── Cards premium ─────────────────────────────────────────── */
        .flower-card-inner {
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.04);
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.4s cubic-bezier(.2,.7,.3,1),
                        box-shadow 0.4s ease;
        }
        .flower-card-inner:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(17, 24, 39, 0.15);
        }
        .flower-card-inner .flower-img-wrap img {
            transition: transform 0.8s cubic-bezier(.2,.7,.3,1);
        }
        .flower-card-inner:hover .flower-img-wrap img { transform: scale(1.06); }

        /* ── Scrollbar invisible en mobile pills ───────────────────── */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Toast ─────────────────────────────────────────────────── */
        @keyframes toastIn {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }
        .toast-in { animation: toastIn 0.35s cubic-bezier(.2,.7,.3,1); }
    </style>

    {{-- ─── Toast confirmación carrito ─── --}}
    @if($cartMessage)
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 lg:left-auto lg:translate-x-0 lg:right-8 z-[60] toast-in
                bg-gray-900 text-white px-5 py-3 rounded-full shadow-2xl text-sm font-medium flex items-center gap-3
                max-w-[calc(100vw-2rem)] sm:max-w-sm"
         wire:key="toast-{{ md5($cartMessage) }}">
        <svg class="w-5 h-5 text-pink-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="flex-1">{{ $cartMessage }}</span>
        <a href="{{ route('cart') }}" class="text-pink-400 hover:text-pink-300 font-semibold whitespace-nowrap">Ver →</a>
    </div>
    @endif

    <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-6 md:py-10">

        {{-- ─── Encabezado ─── --}}
        <div class="mb-8 md:mb-12">
            <p class="text-xs tracking-[0.3em] uppercase text-gray-500 mb-2">Catálogo</p>
            <h1 class="font-serif-display text-3xl md:text-5xl font-light text-gray-900">
                Todos los arreglos
            </h1>
            <div class="w-12 h-px bg-gray-300 mt-4"></div>
        </div>

        <div class="lg:grid lg:grid-cols-[260px_1fr] lg:gap-10">

            {{-- ═══════ SIDEBAR DESKTOP (sticky tipo Amazon) ═══════ --}}
            <aside class="hidden lg:block">
                <div class="sticky top-24 pb-8">
                    <div class="bg-white/60 backdrop-blur-sm border border-gray-200 rounded-2xl p-6">

                        <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                            <h2 class="text-sm font-semibold tracking-wide text-gray-900 uppercase">Filtros</h2>
                            @if($selectedCategory || $search)
                                <button wire:click="clearFilters" class="text-xs text-pink-500 hover:text-pink-600 font-semibold">
                                    Limpiar
                                </button>
                            @endif
                        </div>

                        {{-- Búsqueda --}}
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-2">Buscar</label>
                        <div class="relative mb-6">
                            <input type="text"
                                   wire:model.live.debounce.300ms="search"
                                   placeholder="Nombre o descripción..."
                                   class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm bg-white">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        {{-- Categorías --}}
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-3">Categorías</label>
                        <div class="space-y-1 mb-6">
                            <button wire:click="filterByCategory(null)"
                                    class="w-full text-left px-3 py-2 rounded-lg text-sm transition flex items-center justify-between
                                           {{ !$selectedCategory ? 'bg-pink-500 text-white font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                <span>Todas</span>
                                @if(!$selectedCategory)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </button>
                            @foreach($categories as $category)
                                <button wire:click="filterByCategory({{ $category->id }})"
                                        class="w-full text-left px-3 py-2 rounded-lg text-sm transition flex items-center justify-between
                                               {{ $selectedCategory == $category->id ? 'bg-pink-500 text-white font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <span>{{ $category->name }}</span>
                                    @if($selectedCategory == $category->id)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <span class="text-xs text-gray-400">{{ $category->flowers_count }}</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        {{-- Mostrar cantidad --}}
                        <label class="block text-xs uppercase tracking-wider text-gray-500 mb-2">Mostrar por página</label>
                        <select wire:model.live="perPage"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                            <option value="10">10 productos</option>
                            <option value="20">20 productos</option>
                            <option value="50">50 productos</option>
                            <option value="100">100 productos</option>
                        </select>
                    </div>
                </div>
            </aside>

            {{-- ═══════ CONTENIDO / GRID ═══════ --}}
            <div>
                {{-- Resumen móvil --}}
                <div class="lg:hidden mb-4 flex items-center justify-between text-sm">
                    <p class="text-gray-600">
                        <span class="font-semibold text-gray-900">{{ $flowers->count() }}</span> productos
                        @if($selectedCategory)
                            @php $cat = $categories->firstWhere('id', $selectedCategory); @endphp
                            @if($cat)
                                en <span class="text-pink-500 font-semibold">{{ $cat->name }}</span>
                            @endif
                        @endif
                    </p>
                    @if($selectedCategory || $search)
                        <button wire:click="clearFilters" class="text-xs text-pink-500 font-semibold">× Limpiar</button>
                    @endif
                </div>

                {{-- Resumen desktop --}}
                <div class="hidden lg:flex items-center justify-between mb-6">
                    <p class="text-sm text-gray-600">
                        Mostrando <span class="font-semibold text-gray-900">{{ $flowers->count() }}</span> productos
                    </p>
                </div>

                @if($flowers->count() > 0)
                    {{-- Grid 2x2 móvil / 4x4 desktop --}}
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5 lg:gap-6" wire:key="flowers-grid">
                        @foreach($flowers as $flower)
                            <div class="flower-card" wire:key="flower-{{ $flower->id }}">
                                <div class="flower-card-inner h-full flex flex-col">
                                    {{-- Imagen --}}
                                    <div class="flower-img-wrap relative aspect-[4/5] bg-gray-100 overflow-hidden cursor-pointer group"
                                         onclick="openImageModal(this, '{{ $flower->name }}')"
                                         data-image="{{ $flower->photo_flower_url ? asset('storage/' . $flower->photo_flower_url) : '' }}">
                                        @if($flower->photo_flower_url)
                                            <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                                                 alt="{{ $flower->name }}"
                                                 loading="lazy"
                                                 class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                                </svg>
                                            </div>
                                        @endif

                                        @if($flower->stock <= 0)
                                            <span class="absolute top-2 left-2 bg-gray-900 text-white text-[10px] uppercase tracking-wider font-bold px-2 py-1 rounded-full">Agotado</span>
                                        @elseif($flower->stock < 5)
                                            <span class="absolute top-2 left-2 bg-pink-500 text-white text-[10px] uppercase tracking-wider font-bold px-2 py-1 rounded-full">Pocas</span>
                                        @endif
                                    </div>

                                    {{-- Info --}}
                                    <div class="p-3 md:p-4 flex flex-col flex-1">
                                        @if($flower->categories->isNotEmpty())
                                            <p class="text-[10px] tracking-[0.25em] uppercase text-gray-400 mb-1 truncate">
                                                {{ $flower->categories->first()->name }}
                                            </p>
                                        @endif

                                        <h3 class="font-serif-display text-base md:text-lg font-medium text-gray-900 leading-tight mb-1 line-clamp-1">
                                            {{ $flower->name }}
                                        </h3>

                                        <p class="hidden md:block text-xs text-gray-500 leading-relaxed mb-3 line-clamp-2 min-h-[2.5rem]">
                                            {{ $flower->description }}
                                        </p>

                                        <div class="flex items-baseline justify-between mb-3 mt-auto">
                                            <span class="text-lg md:text-xl font-semibold text-gray-900">
                                                ${{ number_format($flower->price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-[11px] text-gray-400">Stock: {{ $flower->stock }}</span>
                                        </div>

                                        <button wire:click="addToCart({{ $flower->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="addToCart({{ $flower->id }})"
                                                @if($flower->stock <= 0) disabled @endif
                                                class="w-full bg-pink-500 text-white py-2 md:py-2.5 rounded-lg text-xs md:text-sm font-semibold hover:bg-pink-600 transition flex items-center justify-center gap-2 disabled:opacity-40 disabled:cursor-not-allowed">
                                            <svg class="w-4 h-4" wire:loading.remove wire:target="addToCart({{ $flower->id }})" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span wire:loading.remove wire:target="addToCart({{ $flower->id }})">Agregar</span>
                                            <span wire:loading wire:target="addToCart({{ $flower->id }})">Agregando...</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Cargar más --}}
                    @if($hasMore)
                        <div class="text-center mt-12 md:mt-16">
                            <button wire:click="loadMore"
                                    wire:loading.attr="disabled"
                                    wire:target="loadMore"
                                    class="inline-flex items-center gap-2 bg-gray-900 text-white px-7 py-3 rounded-full font-semibold hover:bg-pink-500 transition disabled:opacity-50">
                                <span wire:loading.remove wire:target="loadMore">Cargar más</span>
                                <span wire:loading wire:target="loadMore">Cargando...</span>
                                <svg class="w-4 h-4" wire:loading.remove wire:target="loadMore" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <p class="text-xs text-gray-400 mt-3">{{ $flowers->count() }} productos mostrados</p>
                        </div>
                    @else
                        <p class="text-center text-xs text-gray-400 mt-10">
                            {{ $flowers->count() }} productos · fin del catálogo
                        </p>
                    @endif
                @else
                    <div class="text-center py-20">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                        </svg>
                        <h3 class="font-serif-display text-2xl font-light text-gray-700 mb-3">Sin resultados</h3>
                        <p class="text-gray-500 text-sm mb-6">Intenta cambiar los filtros o buscar otro término.</p>
                        <button wire:click="clearFilters"
                                class="bg-gray-900 text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-pink-500 transition">
                            Ver todos los productos
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════ BOTÓN FLOTANTE FILTROS (MÓVIL) ═══════ --}}
    <button @click="showFilters = true"
            class="lg:hidden fixed bottom-24 right-5 z-30 bg-white text-black px-5 py-3 rounded-full shadow-2xl font-semibold text-sm
                   flex items-center gap-2 border border-gray-200 hover:shadow-xl active:scale-95 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
        </svg>
        Filtros
        @if($selectedCategory || $search)
            <span class="bg-pink-500 text-white text-[10px] w-4 h-4 rounded-full inline-flex items-center justify-center font-bold">1</span>
        @endif
    </button>

    {{-- ═══════ MODAL FILTROS (MÓVIL) ═══════ --}}
    <div x-show="showFilters"
         x-cloak
         @keydown.escape.window="showFilters = false"
         class="lg:hidden fixed inset-0 z-[55]"
         style="display: none;">

        <div x-show="showFilters"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showFilters = false"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div x-show="showFilters"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transform transition ease-in duration-250"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] flex flex-col">

            {{-- Handle + título --}}
            <div class="pt-3 pb-4 px-6 border-b border-gray-100">
                <div class="w-12 h-1 bg-gray-300 rounded-full mx-auto mb-4"></div>
                <div class="flex items-center justify-between">
                    <h3 class="font-serif-display text-xl font-medium text-gray-900">Filtros</h3>
                    <button @click="showFilters = false"
                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200" aria-label="Cerrar">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Contenido scrollable --}}
            <div class="flex-1 overflow-y-auto px-6 py-5">
                {{-- Búsqueda --}}
                <label class="block text-xs uppercase tracking-wider text-gray-500 mb-2">Buscar</label>
                <div class="relative mb-6">
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Nombre o descripción..."
                           class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                {{-- Categorías --}}
                <label class="block text-xs uppercase tracking-wider text-gray-500 mb-3">Categorías</label>
                <div class="space-y-1 mb-6">
                    <button wire:click="filterByCategory(null)"
                            @click="showFilters = false"
                            class="w-full text-left px-3 py-2.5 rounded-lg text-sm transition flex items-center justify-between
                                   {{ !$selectedCategory ? 'bg-pink-500 text-white font-semibold' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}">
                        <span>Todas</span>
                        @if(!$selectedCategory)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        @endif
                    </button>
                    @foreach($categories as $category)
                        <button wire:click="filterByCategory({{ $category->id }})"
                                @click="showFilters = false"
                                class="w-full text-left px-3 py-2.5 rounded-lg text-sm transition flex items-center justify-between
                                       {{ $selectedCategory == $category->id ? 'bg-pink-500 text-white font-semibold' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}">
                            <span>{{ $category->name }}</span>
                            @if($selectedCategory == $category->id)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <span class="text-xs text-gray-400">{{ $category->flowers_count }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>

                {{-- Mostrar cantidad --}}
                <label class="block text-xs uppercase tracking-wider text-gray-500 mb-2">Mostrar por página</label>
                <select wire:model.live="perPage"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                    <option value="10">10 productos</option>
                    <option value="20">20 productos</option>
                    <option value="50">50 productos</option>
                    <option value="100">100 productos</option>
                </select>
            </div>

            {{-- Footer del modal --}}
            <div class="border-t border-gray-100 px-6 py-4 flex gap-3">
                @if($selectedCategory || $search)
                    <button wire:click="clearFilters"
                            class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-full text-sm font-semibold hover:bg-gray-200 transition">
                        Limpiar
                    </button>
                @endif
                <button @click="showFilters = false"
                        class="flex-1 bg-gray-900 text-white py-3 rounded-full text-sm font-semibold hover:bg-pink-500 transition">
                    Ver resultados ({{ $flowers->count() }})
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════ MODAL DE IMAGEN ═══════ --}}
    <div id="imageModal" class="fixed inset-0 bg-black/90 z-[70] hidden items-center justify-center p-4" onclick="closeImageModal(event)">
        <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
            <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-pink-400 transition" aria-label="Cerrar imagen">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg shadow-2xl">
            <p id="modalName" class="text-white text-center mt-3 text-lg font-medium"></p>
        </div>
    </div>

    <script>
        // ─── Modal de imagen ─────────────────────────────────────────
        function openImageModal(el, name) {
            const url = el.dataset.image;
            if (!url) return;
            const modal = document.getElementById('imageModal');
            document.getElementById('modalImage').src = url;
            document.getElementById('modalImage').alt = name;
            document.getElementById('modalName').textContent = name;
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
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeImageModal(); });

        // ─── Reveal horizontal de cards ──────────────────────────────
        (() => {
            const observeCards = () => {
                const cards = document.querySelectorAll('.flower-card:not(.is-revealed)');
                if (!cards.length) return;

                if (!('IntersectionObserver' in window)) {
                    cards.forEach(c => c.classList.add('is-revealed'));
                    return;
                }

                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

                cards.forEach(c => io.observe(c));
            };

            // Primera ejecución
            observeCards();

            // Re-observar después de cada update de Livewire (filtros, load-more)
            document.addEventListener('livewire:initialized', () => {
                Livewire.hook('morph.updated', observeCards);
            });
        })();
    </script>
</div>
