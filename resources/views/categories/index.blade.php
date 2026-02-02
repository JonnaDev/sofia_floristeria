<x-layouts.app :title="__('Categorías')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-700 p-4 md:p-6">

            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg mb-4 md:mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">Categorías</h1>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Mostrando {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} de {{ $categories->total() }} categorías
                    </p>
                </div>
                <a href="{{ route('categories.create') }}" 
                   class="bg-pink-500 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg hover:bg-pink-600 transition font-semibold text-sm md:text-base text-center shadow-sm">
                    <span class="hidden md:inline">+ Nueva Categoría</span>
                    <span class="md:hidden">+ Nueva</span>
                </a>
            </div>

            {{-- Barra de búsqueda --}}
            <div class="mb-4 md:mb-6">
                <form action="{{ route('categories.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 md:gap-3">
                    <div class="flex-1 relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar categoría..."
                               class="w-full px-4 py-2.5 md:py-3 pl-10 border border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="flex gap-2 md:gap-3">
                        <button type="submit" class="flex-1 sm:flex-none bg-pink-500 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg hover:bg-pink-600 transition font-semibold text-sm">
                            Buscar
                        </button>
                        @if(request('search'))
                            <a href="{{ route('categories.index') }}" class="flex-1 sm:flex-none bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-200 px-4 md:px-6 py-2.5 md:py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-zinc-600 transition font-semibold text-sm text-center">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Vista Mobile: Cards --}}
            <div class="md:hidden space-y-3">
                @forelse($categories as $category)
                    <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4 border border-gray-200 dark:border-zinc-700">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-base mb-1">{{ $category->name }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $category->slug }}</p>
                            </div>
                            <span class="bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 text-xs font-semibold px-2.5 py-1 rounded-full">
                                {{ $category->flowers_count }}
                            </span>
                        </div>
                        
                        <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-zinc-700">
                            <a href="{{ route('categories.edit', $category) }}" 
                               class="flex-1 bg-pink-500 text-white px-3 py-2 rounded-lg hover:bg-pink-600 transition text-sm font-medium text-center">
                                Editar
                            </a>
                            <button onclick="if(confirm('¿Estás seguro? Se eliminarán las asociaciones con flores.')) document.getElementById('delete-category-{{ $category->id }}').submit();"
                                    class="flex-1 bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition text-sm font-medium">
                                Eliminar
                            </button>
                        </div>

                        <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 mb-2">No hay categorías registradas</p>
                        <a href="{{ route('categories.create') }}" class="text-pink-600 dark:text-pink-400 font-semibold text-sm">
                            + Crear la primera categoría
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Vista Desktop: Tabla --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Flores</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    #{{ $category->id }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $category->name }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $category->slug }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $category->flowers_count }} flores
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <flux:dropdown>
                                        <flux:button icon-trailing="chevron-down" size="sm" variant="ghost">Acciones</flux:button>

                                        <flux:menu>
                                            <flux:menu.item icon="pencil" href="{{ route('categories.edit', $category) }}" wire:navigate>Editar</flux:menu.item>

                                            <flux:menu.separator />

                                            <flux:menu.item variant="danger" icon="trash" onclick="if(confirm('¿Estás seguro? Se eliminarán las asociaciones con flores.')) document.getElementById('delete-category-{{ $category->id }}').submit();">
                                                Eliminar
                                            </flux:menu.item>
                                        </flux:menu>
                                    </flux:dropdown>

                                    <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 mb-2">No hay categorías registradas</p>
                                    <a href="{{ route('categories.create') }}" class="text-pink-600 dark:text-pink-400 font-semibold">
                                        + Crear la primera categoría
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($categories->hasPages())
                <div class="mt-4 md:mt-6 flex items-center justify-between border-t border-gray-200 dark:border-zinc-700 pt-4">
                    {{-- Mobile Pagination --}}
                    <div class="flex-1 flex justify-between md:hidden">
                        @if($categories->onFirstPage())
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 cursor-not-allowed rounded-lg">
                                Anterior
                            </span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700">
                                Anterior
                            </a>
                        @endif

                        <span class="text-sm text-gray-700 dark:text-gray-300 self-center">
                            {{ $categories->currentPage() }} / {{ $categories->lastPage() }}
                        </span>

                        @if($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700">
                                Siguiente
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 cursor-not-allowed rounded-lg">
                                Siguiente
                            </span>
                        @endif
                    </div>

                    {{-- Desktop Pagination --}}
                    <div class="hidden md:flex md:flex-1 md:items-center md:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Mostrando
                                <span class="font-medium">{{ $categories->firstItem() }}</span>
                                a
                                <span class="font-medium">{{ $categories->lastItem() }}</span>
                                de
                                <span class="font-medium">{{ $categories->total() }}</span>
                                resultados
                            </p>
                        </div>

                        <div>
                            <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                                {{-- Botón Anterior --}}
                                @if($categories->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @endif

                                {{-- Números de página --}}
                                @foreach(range(1, $categories->lastPage()) as $page)
                                    @if($page == $categories->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 border border-pink-400 dark:border-pink-500 bg-pink-50 dark:bg-pink-900/20 text-sm font-medium text-pink-600 dark:text-pink-400">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $categories->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Botón Siguiente --}}
                                @if($categories->hasMorePages())
                                    <a href="{{ $categories->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>