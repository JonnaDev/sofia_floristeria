<x-layouts.app :title="__('Flores a Reabastecer')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">

            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Flores con Stock Bajo</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Flores con 5 o menos unidades disponibles que requieren reabastecimiento
                    </p>
                    @if($flowers->total() > 0)
                        <p class="text-sm font-semibold text-red-600 dark:text-red-400 mt-2">
                            {{ $flowers->total() }} flores necesitan reabastecimiento urgente
                        </p>
                    @endif
                </div>
                <a href="{{ route('restocks.history') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Ver Historial
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Imagen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock Actual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($flowers as $flower)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition {{ $flower->stock == 0 ? 'bg-red-50 dark:bg-red-900/10' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $flower->id }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($flower->photo_flower_url)
                                        <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                                             alt="{{ $flower->name }}"
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $flower->name }}</div>
                                    @if($flower->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($flower->categories as $category)
                                                <span class="text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-full">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-pink-600 dark:text-pink-400 font-bold text-sm">${{ number_format($flower->price, 0, ',', '.') }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($flower->stock == 0)
                                        <flux:badge color="red" size="sm">❌ Agotado</flux:badge>
                                    @elseif($flower->stock <= 2)
                                        <flux:badge color="red" size="sm">⚠️ {{ $flower->stock }} unidades</flux:badge>
                                    @elseif($flower->stock <= 5)
                                        <flux:badge color="amber" size="sm">⚡ {{ $flower->stock }} unidades</flux:badge>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($flower->stock == 0)
                                        <span class="text-xs font-semibold text-red-600 dark:text-red-400">🔴 Crítico</span>
                                    @elseif($flower->stock <= 2)
                                        <span class="text-xs font-semibold text-orange-600 dark:text-orange-400">🟠 Urgente</span>
                                    @else
                                        <span class="text-xs font-semibold text-yellow-600 dark:text-yellow-400">🟡 Bajo</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('restocks.create', $flower) }}"
                                       class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-lg transition font-semibold">
                                        Reabastecer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center">
                                    <div class="text-green-600 dark:text-green-400 text-center">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <h3 class="text-xl font-bold mb-2">¡Excelente! Todas las flores tienen stock suficiente</h3>
                                        <p class="text-gray-500 dark:text-gray-400">No hay flores que requieran reabastecimiento en este momento.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($flowers->hasPages())
                <div class="mt-6 flex items-center justify-between border-t border-gray-200 dark:border-zinc-700 pt-4">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($flowers->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 cursor-not-allowed rounded-md">
                                Anterior
                            </span>
                        @else
                            <a href="{{ $flowers->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700">
                                Anterior
                            </a>
                        @endif

                        @if($flowers->hasMorePages())
                            <a href="{{ $flowers->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700">
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
                                <span class="font-medium">{{ $flowers->firstItem() }}</span>
                                a
                                <span class="font-medium">{{ $flowers->lastItem() }}</span>
                                de
                                <span class="font-medium">{{ $flowers->total() }}</span>
                                flores
                            </p>
                        </div>

                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                @if($flowers->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $flowers->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @endif

                                @foreach(range(1, $flowers->lastPage()) as $page)
                                    @if($page == $flowers->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 border border-green-500 dark:border-green-600 bg-green-50 dark:bg-green-900/20 text-sm font-medium text-green-600 dark:text-green-400">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $flowers->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                @if($flowers->hasMorePages())
                                    <a href="{{ $flowers->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
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
