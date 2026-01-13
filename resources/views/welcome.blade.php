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
    <section id="catalogo" class="py-16 bg-zinc-300 pb-20">
        <div class="container mx-auto px-10">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Nuestras Flores</h2>

            @if($flowers->count() > 0)
                <div class="overflow-x-auto pb-6">
                    <div class="flex gap-6 min-w-max">
                        @foreach($flowers as $flower)
                            <div class="flower-card bg-gray-100 rounded-xl shadow-lg overflow-hidden w-80 flex-shrink-0">
                                <div class="h-64 bg-white flex items-center justify-center overflow-hidden">
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
                                                <span class="text-xs bg-pink-600 text-white text-fond-bold px-2 py-1 rounded-full">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-pink-500">${{ number_format($flower->price, 0, ',', '.') }}</span>
                                        <span class="text-sm text-pink-500">Stock: {{ $flower->stock }}</span>
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
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('1')" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-lg">¿Cómo es el proceso de entrega?</span>
                        <svg id="icon-1" class="w-6 h-6 text-pink-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-1" class="accordion-content px-6 pb-0">
                        <div class="pb-4 text-gray-600">
                            Coordinamos tu pedido por WhatsApp, la entrega se realiza en Neiva y áreas cercanas con tiempos estimados que se confirman al ordenar.
                        </div>
                    </div>
                </div>


                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('2')" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-lg">¿Qué medios de pago manejan?</span>
                        <svg id="icon-2" class="w-6 h-6 text-pink-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-2" class="accordion-content px-6 pb-0">
                        <div class="pb-4 text-gray-600 font-family-arial">
                            Aceptamos transferencias, pagos por Nequi, Daviplata y efectivo.
                        </div>
                    </div>
                </div>


                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('3')" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-lg">¿Puedo hacer cambios en mi pedido?</span>
                        <svg id="icon-3" class="w-6 h-6 text-pink-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-3" class="accordion-content px-6 pb-0">
                        <div class="pb-4 text-gray-600 font-family-arial">
                            Sí, puedes modificar tu pedido con mínimo 24 horas de anticipación a la entrega.
                        </div>
                    </div>
                </div>


                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('4')" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-lg">¿Hacen entregas fuera de Neiva?</span>
                        <svg id="icon-4" class="w-6 h-6 text-pink-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-4" class="accordion-content px-6 pb-0">
                        <div class="pb-4 text-gray-600 font-family-arial">
                            Actualmente trabajamos principalmente en Neiva, pero puedes consultarnos por entregas en otras ciudades.
                        </div>
                    </div>
                </div>


                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('5')" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-lg">¿Cuales son nuestros horarios de atención?</span>
                        <svg id="icon-5" class="w-6 h-6 text-pink-400 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-5" class="accordion-content px-6 pb-0">
                        <div class="pb-4 text-gray-600 font-family-arial">
                            Estamos para servirte de lunes a sábado de 7:00 a.m. a 7:00 p.m. Domingos y festivos: 8:00 a.m. a 12:00 p.m.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Cards 2x2 Section -->
    <section class="py-16 bg-pink-200">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-pink-500 mb-12">Por qué elegirnos?</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">

                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                        <div class="w-16 h-16 bg-pink-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Flores 100% Naturales</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Productos frescos seleccionados cuidadosamente.
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                        <div class="w-16 h-16 bg-pink-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Lorem Ipsum</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.
                        </p>
                    </div>


                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                        <div class="w-16 h-16 bg-pink-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Lorem Ipsum</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.
                        </p>
                    </div>


                    <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                        <div class="w-16 h-16 bg-pink-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Lorem Ipsum</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.
                        </p>
                    </div>


            </div>
        </div>
    </section>

    <!-- Sección de Llamado a Acción WhatsApp -->
    <section class="py-20 bg-gradient-to-r from-pink-100 to-purple-100">
        <div class="container mx-auto px-4 text-center max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">¿Listo para hacer tu pedido?</h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                Estamos listos para ayudarte a sorprender con flores. Escríbenos por WhatsApp y te atenderemos de inmediato.
            </p>
            <a href="https://wa.me/573177261647?text=Hola,%20quiero%20hacer%20un%20pedido%20de%20flores"
               target="_blank"
               class="inline-flex items-center gap-3 bg-green-500 text-white px-8 py-4 rounded-lg text-lg font-bold hover:bg-green-600 transition shadow-lg hover:shadow-xl">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Contactar por WhatsApp
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-700 text-white py-12">
        <div class="container mx-auto px-16">
            <!-- Contenido Principal del Footer -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

                <!-- Columna 1: Información de la Florería -->
                <div class="flex flex-col items-start">
                    <h3 class="text-2xl font-bold mb-4">Sofía Floristería</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Flores que hacen inolvidables tus momentos más especiales.
                    </p>
                </div>

                <!-- Columna 2: Navegación -->
                <div class="flex flex-col items-start ml-8">
                    <h4 class="text-lg font-bold mb-4">Navegación</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition text-sm">Inicio</a></li>
                        <li><a href="#catalogo" class="text-gray-300 hover:text-white transition text-sm">Productos</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition text-sm">Categorías</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition text-sm">Favoritos</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition text-sm">Carrito</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Contacto -->
                <div class="flex flex-col items-start ml-8">
                    <h4 class="text-lg font-bold mb-4">Contacto</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <a href="mailto:fraysury18@gmail.com" class="hover:text-white transition">fraysury18@gmail.com</a>
                        </li>
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <a href="tel:+573177261647" class="hover:text-white transition">+57 3177261647</a>
                        </li>
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <a href="tel:+573153592689" class="hover:text-white transition">+57 3153592689</a>
                        </li>
                        <li class="flex items-start gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Calle 16 # 2-48<br>Neiva - Huila</span>
                        </li>
                    </ul>
                </div>

                <!-- Columna 4: Redes Sociales -->
                <div class="flex flex-col items-start ml-8">
                    <h4 class="text-lg font-bold mb-4">Síguenos</h4>
                    <div class="flex flex-col gap-3">
                        <a href="https://web.facebook.com/people/Floristería-Sofía/100064982413493/"
                           target="_blank"
                           class="flex items-center gap-3 text-gray-300 hover:text-white transition group">
                            <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center group-hover:bg-blue-600 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">Facebook</span>
                        </a>
                        <a href="https://www.instagram.com/floristeriasofianeiva"
                           target="_blank"
                           class="flex items-center gap-3 text-gray-300 hover:text-white transition group">
                            <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center group-hover:bg-gradient-to-br group-hover:from-purple-600 group-hover:via-pink-600 group-hover:to-orange-600 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">Instagram</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Línea Separadora -->
            <div class="border-t border-gray-600 mt-8 pt-6">
                <p class="text-center text-gray-400 text-sm">
                    © 2026 Sofía Floristería. Todos los derechos reservados.
                </p>
            </div>
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
