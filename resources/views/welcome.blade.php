<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sofía Florería</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .flower-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.active {
            max-height: 500px;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="text-2xl font-bold text-pink-600 hover:text-pink-400 transition">
                Sofía Florería
            </div>

            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 px-5 py-2 rounded-lg shadow-lg hover:text-white hover:bg-pink-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-gray-400 text-black px-5 py-2 rounded-lg hover:text-white hover:bg-pink-600 transition">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 transition">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-pink-100 to-purple-100 py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold text-gray-800 mb-4">Flores Frescas para Cada Momento</h1>
            <p class="text-xl text-gray-600 mb-8">Arreglos únicos hechos con amor</p>
            <a href="#catalogo" class="bg-pink-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-pink-700 transition inline-block">
                Ver Catálogo
            </a>
        </div>
    </section>

    <!-- Carousel de Flores -->
    <section id="catalogo" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Nuestras Flores</h2>

            @if($flowers->count() > 0)
                <div class="overflow-x-auto pb-6">
                    <div class="flex gap-6 min-w-max">
                        @foreach($flowers as $flower)
                            <div class="flower-card bg-gray-100 rounded-xl shadow-lg overflow-hidden w-80 flex-shrink-0">
                                <div class="h-64 bg-gradient-to-br from-pink-200 to-purple-200 flex items-center justify-center overflow-hidden">
                                    @if($flower->photo_flower_url)
                                        <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                                             alt="{{ $flower->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-32 h-32 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $flower->name }}</h3>
                                    <p class="text-gray-600 mb-3 text-sm line-clamp-2">
                                        {{ $flower->description ?? 'Hermoso arreglo floral disponible en nuestra florería.' }}
                                    </p>

                                    @if($flower->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1 mb-3">
                                            @foreach($flower->categories as $category)
                                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-green-500">${{ number_format($flower->price, 0, ',', '.') }}</span>
                                        <span class="text-sm text-green-500">Stock: {{ $flower->stock }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <svg class="w-32 h-32 text-gray-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                    </svg>
                    <h3 class="text-3xl font-bold text-gray-700 mb-4">Actualmente la florería no tiene flores listas para vender</h3>
                    <p class="text-gray-500 text-lg">Estamos preparando nuevos arreglos florales. Vuelve pronto.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Preguntas Frecuentes</h2>

            <div class="space-y-4">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <button onclick="toggleAccordion('{{ $i }}')" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-800 text-lg">Lorem ipsum dolor sit amet {{ $i }}?</span>
                            <svg id="icon-{{ $i }}" class="w-6 h-6 text-pink-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="content-{{ $i }}" class="accordion-content px-6 pb-0">
                            <div class="pb-4 text-gray-600">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Cards 2x2 Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Sobre Nosotros</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                        <div class="w-16 h-16 bg-pink-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Lorem Ipsum {{ $i }}</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.
                        </p>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-4">Sofía Florería</h3>
            <p class="text-gray-400 mb-6">Flores frescas con amor desde 2026</p>
            <div class="flex justify-center gap-6">
                <a href="#" class="text-gray-400 hover:text-white transition">Facebook</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
                <a href="#" class="text-gray-400 hover:text-white transition">WhatsApp</a>
            </div>
            <p class="text-gray-500 text-sm mt-8">&copy; 2026 Sofía Florería. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function toggleAccordion(index) {
            const content = document.getElementById(`content-${index}`);
            const icon = document.getElementById(`icon-${index}`);

            content.classList.toggle('active');
            icon.classList.toggle('rotate-180');
        }
    </script>
</body>
</html>
