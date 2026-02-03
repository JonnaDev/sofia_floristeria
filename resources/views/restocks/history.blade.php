<x-layouts.app :title="__('Historial de Reabastecimientos')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-700 p-4 md:p-6">

            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white">Historial de Reabastecimientos</h1>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Registro completo de todos los reabastecimientos
                    </p>
                    @if($restocks->total() > 0)
                        <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Total: {{ $restocks->total() }} registros
                        </p>
                    @endif
                </div>
                <a href="{{ route('restocks.index') }}" 
                   class="bg-pink-500 text-white px-4 md:px-6 py-2.5 md:py-3 rounded-lg hover:bg-pink-600 transition font-semibold text-sm md:text-base text-center">
                    Ir a Reabastecimiento
                </a>
            </div>

            {{-- Vista Mobile: Cards --}}
            <div class="md:hidden space-y-4">
                @forelse($restocks as $restock)
                    <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700 p-4">
                        {{-- Header: Fecha + ID --}}
                        <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-200 dark:border-zinc-700">
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $restock->created_at->format('d/m/Y H:i') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $restock->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">#{{ $restock->id }}</span>
                        </div>

                        {{-- Flor con imagen --}}
                        <div class="flex items-center gap-3 mb-3">
                            @if($restock->flower && $restock->flower->photo_flower_url)
                                <img src="{{ asset('storage/' . $restock->flower->photo_flower_url) }}"
                                     alt="{{ $restock->flower->name }}"
                                     class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div class="w-16 h-16 bg-gray-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                                    {{ $restock->flower ? $restock->flower->name : 'Flor eliminada' }}
                                </p>
                                @if($restock->flower && $restock->flower->categories->count() > 0)
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($restock->flower->categories->take(2) as $category)
                                            <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-xs px-2 py-0.5 rounded-full">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Stock Info Grid --}}
                        <div class="grid grid-cols-3 gap-2 mb-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Anterior</p>
                                <p class="text-lg font-bold text-gray-700 dark:text-gray-300">{{ $restock->previous_stock }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Agregado</p>
                                <p class="text-lg font-bold text-green-600 dark:text-green-400">+{{ $restock->added_quantity }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Nuevo</p>
                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $restock->new_stock }}</p>
                            </div>
                        </div>

                        {{-- Usuario --}}
                        <div class="mb-2">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Usuario:</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ $restock->user ? $restock->user->name : 'Desconocido' }}
                            </p>
                        </div>

                        {{-- Notas --}}
                        @if($restock->notes)
                            <div class="bg-gray-100 dark:bg-zinc-700 rounded p-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Notas:</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $restock->notes }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">Sin Registros</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Aún no hay reabastecimientos</p>
                        <a href="{{ route('restocks.index') }}" class="text-pink-600 dark:text-pink-400 hover:underline text-sm font-semibold">
                            Realizar primer reabastecimiento
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Vista Desktop: Tabla --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Flor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Anterior</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Agregado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nuevo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Notas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($restocks as $restock)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
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
                                                 class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
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
                                                        <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-xs px-2 py-0.5 rounded-full">
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
                                        {{ $restock->user ? $restock->user->name : 'Desconocido' }}
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
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">Sin Registros de Reabastecimiento</h3>
                                    <p class="text-gray-500 dark:text-gray-400">Aún no se han realizado reabastecimientos</p>
                                    <a href="{{ route('restocks.index') }}" class="text-pink-600 dark:text-pink-400 hover:underline mt-2 inline-block font-semibold">
                                        Realizar primer reabastecimiento
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($restocks->hasPages())
                <div class="mt-4 md:mt-6 flex items-center justify-between border-t border-gray-200 dark:border-zinc-700 pt-4">
                    {{-- Mobile --}}
                    <div class="flex-1 flex justify-between md:hidden">
                        @if($restocks->onFirstPage())
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 cursor-not-allowed rounded-lg">Anterior</span>
                        @else
                            <a href="{{ $restocks->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700">Anterior</a>
                        @endif

                        <span class="text-sm text-gray-700 dark:text-gray-300 self-center">
                            {{ $restocks->currentPage() }} / {{ $restocks->lastPage() }}
                        </span>

                        @if($restocks->hasMorePages())
                            <a href="{{ $restocks->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700">Siguiente</a>
                        @else
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 cursor-not-allowed rounded-lg">Siguiente</span>
                        @endif
                    </div>

                    {{-- Desktop --}}
                    <div class="hidden md:flex md:flex-1 md:items-center md:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Mostrando <span class="font-medium">{{ $restocks->firstItem() }}</span>
                                a <span class="font-medium">{{ $restocks->lastItem() }}</span>
                                de <span class="font-medium">{{ $restocks->total() }}</span> registros
                            </p>
                        </div>

                        <div>
                            <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px">
                                @if($restocks->onFirstPage())
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </span>
                                @else
                                    <a href="{{ $restocks->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </a>
                                @endif

                                @foreach(range(1, min($restocks->lastPage(), 5)) as $page)
                                    @if($page == $restocks->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 border border-pink-400 dark:border-pink-500 bg-pink-50 dark:bg-pink-900/20 text-sm font-medium text-pink-600 dark:text-pink-400">{{ $page }}</span>
                                    @else
                                        <a href="{{ $restocks->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($restocks->hasMorePages())
                                    <a href="{{ $restocks->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-r-lg border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
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