<x-layouts.app :title="__('Crear Categoría')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-8 max-w-2xl mx-auto w-full">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Crear Nueva Categoría</h1>

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-6">
                    <strong class="font-bold">¡Oops! Hay algunos errores:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                        Nombre de la Categoría <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('name') border-red-500 @enderror"
                        placeholder="Ej: Rosas, Tulipanes, Flores Exóticas...">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">El slug se generará automáticamente</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-green-800 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                        Crear Categoría
                    </button>
                    <a href="{{ route('categories.index') }}" class="bg-gray-300 dark:bg-zinc-700 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-lg hover:bg-gray-400 dark:hover:bg-zinc-600 transition font-semibold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
