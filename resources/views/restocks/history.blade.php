<x-layouts.app :title="__('Historial de Reabastecimientos')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Historial de Reabastecimientos</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Registro completo de todos los reabastecimientos realizados
                    </p>
                    @if($restocks->total() > 0)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Total: {{ $restocks->total() }} registros
                        </p>
                    @endif
                </div>
                <a href="{{ route('restocks.index') }}" class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                    Ir a Reabastecimiento
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha y Hora</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Flor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock Anterior</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cantidad Agregada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nuevo Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Notas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($restocks as $restock)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    #{{ $restock->id }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $restock->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $restock->created_at->format('H:i:s') }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $restock->created_at->diffForHumans() }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($restock->flower && $restock->flower->photo_flower_url)
                                            <img src="{{ asset('storage/' . $restock->flower->photo_flower_url) }}"
                                                 alt="{{ $restock->flower->name }}"
                                                 class="w-12 h-12 object-cover rounded-lg">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $restock->flower ? $restock->flower->name : 'Flor eliminada' }}
                                            </div>
                                            @if($restock->flower && $restock->flower->categories->count() > 0)
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    @foreach($restock->flower->categories as $category)
                                                        <span class="text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-full">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                                        {{ $restock->previous_stock }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                        +{{ $restock->added_quantity }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                        {{ $restock->new_stock }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $restock->user ? $restock->user->name : 'Usuario desconocido' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $restock->user ? $restock->user->email : '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if($restock->notes)
                                        <p class="text-sm text-gray-700 dark:text-gray-300 max-w-xs">
                                            {{ $restock->notes }}
                                        </p>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500 italic">Sin notas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                        </svg>
                                        <h3 class="text-lg font-bold mb-2">No hay registros de reabastecimiento</h3>
                                        <p>Aún no se han realizado reabastecimientos en el sistema.</p>
                                        <a href="{{ route('restocks.index') }}" class="text-green-600 dark:text-green-400 hover:underline mt-2 inline-block">
                                            Realizar primer reabastecimiento
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($restocks->hasPages())
                <div class="mt-6 flex items-center justify-between border-t border-gray-200 dark:border-zinc-700 pt-4">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($restocks->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 cursor-not-allowed rounded-md">
                                Anterior
                            </span>
                        @else
                            <a href="{{ $restocks->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700">
                                Anterior
                            </a>
                        @endif

                        @if($restocks->hasMorePages())
                            <a href="{{ $restocks->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700">
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
                                <span class="font-medium">{{ $restocks->firstItem() }}</span>
                                a
                                <span class="font-medium">{{ $restocks->lastItem() }}</span>
                                de
                                <span class="font-medium">{{ $restocks->total() }}</span>
                                registros
                            </p>
                        </div>

                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                @if($restocks->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $restocks->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                @endif

                                @foreach(range(1, min($restocks->lastPage(), 5)) as $page)
                                    @if($page == $restocks->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 border border-blue-500 dark:border-blue-600 bg-blue-50 dark:bg-blue-900/20 text-sm font-medium text-blue-600 dark:text-blue-400">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $restocks->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                @if($restocks->hasMorePages())
                                    <a href="{{ $restocks->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
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
