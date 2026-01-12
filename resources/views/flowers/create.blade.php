<x-layouts.app :title="__('Crear Nueva Flor')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-8 max-w-4xl mx-auto w-full">

            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Crear Nueva Flor</h1>

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

            <form action="{{ route('flowers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">
                        Nombre de la Flor <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('name') border-red-500 @enderror"
                        placeholder="Ej: Rosa Roja Premium">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label for="price" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Precio <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}"
                        class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('price') border-red-500 @enderror"
                        placeholder="Ej: 49999">
                    @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label for="stock" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Stock Inicial <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}"
                        class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('stock') border-red-500 @enderror"
                        placeholder="Ej: 100">
                    @error('stock')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Descripción</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('description') border-red-500 @enderror"
                        placeholder="Describe la flor...">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label for="photo_flower_url" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Imagen de la Flor <span class="text-red-500">*</span></label>
                    <input type="file" name="photo_flower_url" id="photo_flower_url" accept="image/jpeg,image/jpg,image/png,image/webp"
                        class="w-full px-4 py-2 border dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 @error('photo_flower_url') border-red-500 @enderror"
                        onchange="previewImage(event)">
                    @error('photo_flower_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="preview" src="" alt="Vista previa" class="max-w-xs rounded-lg shadow-md">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Categorías <span class="text-red-500">*</span></label>
                    <div class="border dark:border-zinc-700 dark:bg-zinc-800 rounded-lg p-4 max-h-48 overflow-y-auto @error('category_ids') border-red-500 @enderror">
                        @forelse($categories ?? [] as $category)
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                    {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}
                                    class="mr-2 w-4 h-4 text-pink-600 focus:ring-pink-500">
                                <span class="text-gray-700 dark:text-gray-200">{{ $category->name }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No hay categorías disponibles. <a href="{{ route('categories.create') }}" class="text-pink-600 underline">Crear una</a></p>
                        @endforelse
                    </div>
                    @error('category_ids')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition font-semibold">Crear Flor</button>
                    <a href="{{ route('flowers.index') }}" class="bg-gray-300 dark:bg-zinc-700 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-lg hover:bg-gray-400 dark:hover:bg-zinc-600 transition font-semibold">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-layouts.app>
