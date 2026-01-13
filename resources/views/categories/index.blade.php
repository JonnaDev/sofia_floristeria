<x-layouts.app :title="__('Categorías')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">

            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Categorías</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Mostrando {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} de {{ $categories->total() }} categorías
                    </p>
                </div>
                <a href="{{ route('categories.create') }}" class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                    + Nueva Categoría
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Flores Asociadas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $category->id }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $category->name }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $category->slug }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <flux:badge color="purple" size="sm">{{ $category->flowers_count }} flores</flux:badge>
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
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        No hay categorías registradas.
                                        <a href="{{ route('categories.create') }}" class="text-purple-600 dark:text-purple-400 underline">Crear la primera</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación estilo Flux --}}
            @if($categories->hasPages())
                <div class="mt-6 flex items-center justify-between border-t border-gray-200 dark:border-zinc-700 pt-4">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($categories->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 cursor-not-allowed rounded-md">
                                Anterior
                            </span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700">
                                Anterior
                            </a>
                        @endif

                        @if($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700">
                                Siguiente
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 cursor-not-allowed rounded-md">
                                Siguiente
                            </span>
                        @endif
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
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
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                {{-- Botón Anterior --}}
                                @if($categories->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $categories->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @endif

                                {{-- Números de página --}}
                                @foreach(range(1, $categories->lastPage()) as $page)
                                    @if($page == $categories->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 border border-purple-500 dark:border-purple-600 bg-purple-50 dark:bg-purple-900/20 text-sm font-medium text-purple-600 dark:text-purple-400">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $categories->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Botón Siguiente --}}
                                @if($categories->hasMorePages())
                                    <a href="{{ $categories->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
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
