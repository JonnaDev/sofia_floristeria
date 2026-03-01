<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Florería en Neiva con entrega rápida a domicilio. Arreglos florales para cumpleaños, amor y ocasiones especiales. Compra fácil por WhatsApp.">
    <title>Sofía Floristería - Neiva | Flores a Domicilio</title>

    <!-- Canonical URL -->
    <link rel="canonical" href="https://sofianeivafloristeria.com/">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sofianeivafloristeria.com/">
    <meta property="og:title" content="Sofía Floristería - Neiva | Flores a Domicilio">
    <meta property="og:description" content="Florería en Neiva con entrega rápida a domicilio. Arreglos florales para cumpleaños, amor y ocasiones especiales. Compra fácil por WhatsApp.">
    <meta property="og:image" content="https://sofianeivafloristeria.com/images/logo.WebP">
    <meta property="og:locale" content="es_CO">
    <meta property="og:site_name" content="Sofía Floristería">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sofía Floristería - Neiva | Flores a Domicilio">
    <meta name="twitter:description" content="Florería en Neiva con entrega rápida a domicilio. Arreglos florales para cumpleaños, amor y ocasiones especiales.">
    <meta name="twitter:image" content="https://sofianeivafloristeria.com/images/logo.WebP">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LTS541GNH5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-LTS541GNH5');
    </script>


    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animación de entrada suave para toda la página */
        body {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Animación para elementos que se deslizan hacia arriba */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        .fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        /* Hover effect para las cards de flores */
        .flower-card {
            transition: all 0.3s ease;
        }

        .flower-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        /* Accordion styles */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.active {
            max-height: 500px;
        }

        /* Text clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Carousel container */
        .carousel-container {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        /* Hide scrollbar but keep functionality */
        .carousel-container::-webkit-scrollbar {
            display: none;
        }
        .carousel-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Mobile menu animation */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }
    </style>
</head>
<body>

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4">
            <!-- Desktop Navigation -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/logo.png') }}" alt="Sofía Florería" class="h-16 md:h-20 w-auto drop-shadow-lg hover:drop-shadow-[0_0_15px_rgba(236,72,153,0.6)]">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8 text-lg">
                    <a href="{{ route('home') }}" class="text-pink-500 hover:text-pink-600 transition font-semibold">Inicio</a>
                    <a href="{{ route('catalog') }}" class="text-pink-500 hover:text-pink-600 transition font-semibold">Catálogo</a>
                    <a href="{{ route('cart') }}" class="relative text-pink-500 hover:text-pink-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartCount > 9 ? '9+' : $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Auth Links Desktop -->
                <div class="hidden md:flex items-center gap-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 px-5 py-2 rounded-lg shadow-lg hover:text-white hover:bg-pink-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 transition">Iniciar Sesión</a>
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-pink-500 focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Overlay -->
            <div id="mobile-menu" class="mobile-menu fixed top-0 right-0 h-full w-64 bg-white shadow-2xl z-50 md:hidden">
                <div class="p-6">
                    <button id="close-menu-btn" class="absolute top-4 right-4 text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="mt-8 flex flex-col gap-6">
                        <a href="{{ route('home') }}" class="text-pink-500 hover:text-pink-600 transition font-semibold text-lg">Inicio</a>
                        <a href="{{ route('catalog') }}" class="text-pink-500 hover:text-pink-600 transition font-semibold text-lg">Catálogo</a>
                        <a href="{{ route('cart') }}" class="flex items-center gap-2 text-pink-500 hover:text-pink-600 transition font-semibold text-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Carrito
                            @php $cartCountMobile = count(session('cart', [])); @endphp
                            @if($cartCountMobile > 0)
                                <span class="bg-pink-600 text-white text-xs font-bold rounded-full px-2 py-0.5">{{ $cartCountMobile }}</span>
                            @endif
                        </a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 px-5 py-2 rounded-lg shadow-lg hover:text-white hover:bg-pink-600 transition text-center">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 transition text-center">Iniciar Sesión</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Modal de error para usuarios no autorizados -->
    @if(session('error'))
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md mx-4 p-8"> 
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Acceso Denegado</h3>
                <p class="text-gray-600 mb-6">{{ session('error') }}</p>
                <button onclick="document.getElementById('errorModal').remove()" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-semibold">
                    Entendido
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Hero Section -->
    <section class="relative w-full h-screen flex items-center justify-center overflow-hidden">

    <img
        src="{{ asset('images/flower-background.WebP') }}"
        alt=""
        class="absolute inset-0 w-full h-full object-cover"
    >

    <!-- Frosted-glass card centrado -->
    <div class="relative z-10 w-full max-w-2xl mx-auto px-6 md:px-12 py-12 md:py-20 rounded-2xl text-center"
         style="background: rgba(100, 60, 70, 0.52); backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);">

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: serif;">
            Bienvenido a Sofía Floristería Neiva
        </h1>

        <p class="text-white text-base md:text-lg mb-2 opacity-90">
            Explora nuestros productos y disfruta una gran variedad.
        </p>
        <p class="text-white text-sm md:text-base mb-8 opacity-80">
            ¡Haz tu pedido hoy y alegra tu día!
        </p>

        <a href="{{ route('catalog') }}"
           class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold px-7 py-3 rounded-full transition shadow-lg text-base md:text-lg">
            Ver productos
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>

    <!-- Carousel de Flores -->
    <section id="catalogo" class="py-12 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8 md:mb-12">Arreglos florales en Neiva más vendidos</h2>

            @if($flowers->count() > 0) 
                <div class="relative">
                    <!-- Carousel Container -->
                    <div id="flowerCarousel" class="carousel-container overflow-x-auto pb-6">
                        <div class="flex gap-4 md:gap-6 px-2">
                            @foreach($flowers as $flower)
                                <a href="{{ route('catalog') }}?category_id={{ $flower->categories->first()?->id ?? '' }}#flores"
                                   class="flower-card bg-white rounded-xl shadow-xl overflow-hidden w-72 md:w-80 flex-shrink-0 block">
                                    <div class="h-48 md:h-64 bg-white flex items-center justify-center overflow-hidden">
                                        @if($flower->photo_flower_url)
                                            <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                                                 alt="{{ $flower->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-24 h-24 md:w-32 md:h-32 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="p-4 md:p-6">
                                        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">{{ $flower->name }}</h3>
                                        <p class="text-gray-600 mb-3 text-sm line-clamp-2">
                                            {{ $flower->description ?? 'Hermoso arreglo floral disponible en nuestra florería.' }}
                                        </p>

                                        @if($flower->categories->count() > 0)
                                            <div class="flex flex-wrap gap-1 mb-3">
                                                @foreach($flower->categories as $category)
                                                    <span class="text-xs bg-pink-600 text-white px-2 py-1 rounded-full">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="flex justify-between items-center">
                                            <span class="text-xl md:text-2xl font-bold text-pink-500">${{ number_format($flower->price, 0, ',', '.') }}</span>
                                            <span class="text-sm md:text-md font-bold text-pink-500">Stock: {{ $flower->stock }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-center gap-4 mt-6">
                        <button id="prevBtn" class="w-12 h-12 bg-pink-500 text-white rounded-full flex items-center justify-center hover:bg-pink-600 transition shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button id="nextBtn" class="w-12 h-12 bg-pink-500 text-white rounded-full flex items-center justify-center hover:bg-pink-600 transition shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @else
                <div class="text-center py-12 md:py-20">
                    <svg class="w-24 h-24 md:w-32 md:h-32 text-gray-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                    </svg>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-700 mb-4">Actualmente la florería no tiene flores listas para vender</h3>
                    <p class="text-gray-500 text-base md:text-lg">Estamos preparando nuevos arreglos florales. Vuelve pronto.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section class="py-12 md:py-16 bg-gradient-to-br from-pink-50 via-purple-50 to-pink-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">Lo Que Dicen Nuestros Clientes</h2>
            <p class="text-center text-gray-600 mb-8 md:mb-12">Testimonios reales de quienes confían en nosotros</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-6xl mx-auto">
                <!-- Review Card 1 - Mujer (Rosa) -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300">
                    <div class="h-48 md:h-64 bg-pink-100 flex items-center justify-center">
                        <svg class="w-28 h-28 md:w-36 md:h-36 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-4 text-sm md:text-base italic">
                            "¡Increíbles! Las flores llegaron frescas y hermosas. Mi mamá lloró de la emoción. Totalmente recomendados."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-gray-800">María González</p>
                                <p class="text-sm text-gray-500">Cliente verificada</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Card 2 - Hombre (Azul) -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300">
                    <div class="h-48 md:h-64 bg-blue-100 flex items-center justify-center">
                        <svg class="w-28 h-28 md:w-36 md:h-36 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-4 text-sm md:text-base italic">
                            "Excelente servicio y atención. El arreglo superó mis expectativas. La entrega fue puntual y profesional."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-gray-800">Carlos Ramírez</p>
                                <p class="text-sm text-gray-500">Cliente verificado</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Card 3 - Mujer (Rosa) -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300">
                    <div class="h-48 md:h-64 bg-pink-100 flex items-center justify-center">
                        <svg class="w-28 h-28 md:w-36 md:h-36 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 mb-4 text-sm md:text-base italic">
                            "Perfectos para sorprender a mi esposa en nuestro aniversario. La calidad es excepcional. ¡Volveré!"
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold text-gray-800">Laura Martínez</p>
                                <p class="text-sm text-gray-500">Cliente verificada</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8 md:mb-12">Preguntas Frecuentes</h2>

            <div class="space-y-4">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('1')" class="w-full px-4 md:px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-base md:text-lg pr-4">¿Cómo es el proceso de entrega?</span>
                        <svg id="icon-1" class="w-6 h-6 text-pink-400 transform transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-1" class="accordion-content px-4 md:px-6 pb-0">
                        <div class="pb-4 text-gray-600 text-sm md:text-base">
                            Coordinamos tu pedido por WhatsApp, la entrega se realiza en Neiva y áreas cercanas con tiempos estimados que se confirman al ordenar.
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('2')" class="w-full px-4 md:px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-base md:text-lg pr-4">¿Qué medios de pago manejan?</span>
                        <svg id="icon-2" class="w-6 h-6 text-pink-400 transform transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-2" class="accordion-content px-4 md:px-6 pb-0">
                        <div class="pb-4 text-gray-600 text-sm md:text-base">
                            Aceptamos transferencias, pagos por Nequi, Daviplata y efectivo.
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('3')" class="w-full px-4 md:px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-base md:text-lg pr-4">¿Puedo hacer cambios en mi pedido?</span>
                        <svg id="icon-3" class="w-6 h-6 text-pink-400 transform transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-3" class="accordion-content px-4 md:px-6 pb-0">
                        <div class="pb-4 text-gray-600 text-sm md:text-base">
                            Sí, puedes modificar tu pedido con mínimo 24 horas de anticipación a la entrega.
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('4')" class="w-full px-4 md:px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-base md:text-lg pr-4">¿Hacen entregas fuera de Neiva?</span>
                        <svg id="icon-4" class="w-6 h-6 text-pink-400 transform transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-4" class="accordion-content px-4 md:px-6 pb-0">
                        <div class="pb-4 text-gray-600 text-sm md:text-base">
                            Actualmente trabajamos principalmente en Neiva, pero puedes consultarnos por entregas en otras ciudades.
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button onclick="toggleAccordion('5')" class="w-full px-4 md:px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-800 text-base md:text-lg pr-4">¿Cuales son nuestros horarios de atención?</span>
                        <svg id="icon-5" class="w-6 h-6 text-pink-400 transform transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="content-5" class="accordion-content px-4 md:px-6 pb-0">
                        <div class="pb-4 text-gray-600 text-sm md:text-base">
                            Estamos para servirte de lunes a sábado de 7:00 a.m. a 7:00 p.m. Domingos y festivos: 8:00 a.m. a 12:00 p.m.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Por qué elegirnos Section -->
    <section class="py-12 md:py-16 bg-pink-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-pink-500 mb-12 md:mb-16 fade-in">¿Por qué elegirnos?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-16 max-w-6xl mx-auto">
                <!-- Primera Card: Flores 100% Naturales -->
                <div class="flex flex-col p-5 items-center bg-pink-50 rounded-2xl text-center fade-in-up" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 md:w-24 md:h-24 mb-6">
                        <svg class="w-full h-full text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C10.343 2 9 3.343 9 5c0 .552.224 1.052.586 1.414L12 8.828l2.414-2.414C14.776 6.052 15 5.552 15 5c0-1.657-1.343-3-3-3zm0 0"></path>
                            <path d="M19.071 4.929c-1.562-1.562-4.095-1.562-5.657 0L12 6.343 10.586 4.93c-1.562-1.562-4.095-1.562-5.657 0s-1.562 4.095 0 5.657l7.071 7.07 7.071-7.07c1.562-1.562 1.562-4.095 0-5.657z"></path>
                            <path d="M12 22c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm5-7c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-10 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">Flores 100% Naturales</h3>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                        Productos frescos seleccionados cuidadosamente.
                    </p>
                </div>

                <!-- Segunda Card: Entrega en Neiva -->
                <div class="flex flex-col p-5 items-center bg-pink-50 rounded-2xl text-center fade-in-up" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 md:w-24 md:h-24 mb-6">
                        <svg class="w-full h-full text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 18.5a1.5 1.5 0 01-1.5-1.5 1.5 1.5 0 01 1.5-1.5 1.5 1.5 0 011.5 1.5 1.5 1.5 0 01-1.5 1.5m1.5-9l1.96 2.5H17V9.5m-11 9A1.5 1.5 0 017.5 17 1.5 1.5 0 016 15.5 1.5 1.5 0 017.5 14 1.5 1.5 0 019 15.5 1.5 1.5 0 017.5 17M20 8h-3V4H3c-1.11 0-2 .89-2 2v11h2a3 3 0 003 3 3 3 0 003-3h6a3 3 0 003 3 3 3 0 003-3h2v-5l-3-4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">Entrega en Neiva</h3>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                        Coordinamos tu entrega directamente vía WhatsApp.
                    </p>
                </div>

                <!-- Tercera Card: Pedidos Seguros -->
                <div class="flex flex-col p-5 items-center bg-pink-50 rounded-2xl text-center fade-in-up" style="animation-delay: 0.6s;">
                    <div class="w-20 h-20 md:w-24 md:h-24 mb-6">
                        <svg class="w-full h-full text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2v-2h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-6 18H10v-2h4v2zm6-4H4V4h16v12z"></path>
                            <path d="M12 6c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm-1.5 6v-4l3 2-3 2z" fill="white"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-3">Pedidos Seguros</h3>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                        Gestiona tu pedido con total tranquilidad y confianza.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Ubicación del Negocio -->
    <section class="py-12 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">Encuéntranos</h2>
            <p class="text-center text-gray-500 mb-10 md:mb-12 text-sm md:text-base">Visítanos en nuestra tienda física en el corazón de Neiva</p>

            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-stretch">

                <!-- Foto fachada + info -->
                <div class="flex flex-col gap-4">
                    <!-- Foto del negocio -->
                    <div class="rounded-2xl overflow-hidden shadow-xl flex-1">
                        <img src="{{ asset('images/sofia_floristeria_negocio_fisico.webp') }}"
                             alt="Fachada Sofía Floristería Neiva - Cl. 16 #2-48 Los Potros"
                             class="w-full h-56 md:h-72 object-cover">
                    </div>

                    <!-- Info de contacto/horario -->
                    <div class="bg-pink-50 rounded-2xl p-5 md:p-6 shadow-md">
                        <div class="space-y-3">
                            <!-- Dirección -->
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-pink-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">Dirección</p>
                                    <p class="text-gray-600 text-sm">Cl. 16 #2-48, Los Potros<br>Neiva, Huila, Colombia</p>
                                </div>
                            </div>
                            <!-- Horario -->
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-pink-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">Horario</p>
                                    <p class="text-gray-600 text-sm">Lun – Sáb: 7:00 a.m. – 7:00 p.m.</p>
                                    <p class="text-gray-600 text-sm">Dom y festivos: 8:00 a.m. – 12:00 p.m.</p>
                                </div>
                            </div>
                            <!-- Teléfono -->
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-pink-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">Teléfonos</p>
                                    <a href="tel:+573177261647" class="text-pink-600 hover:text-pink-700 text-sm block">+57 317 726 1647</a>
                                    <a href="tel:+573153592689" class="text-pink-600 hover:text-pink-700 text-sm block">+57 315 359 2689</a>
                                </div>
                            </div>
                        </div>
                        <!-- Botón Google Maps -->
                        <a href="https://maps.app.goo.gl/3r3XP7KQhRvmH2PAA"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="mt-4 w-full flex items-center justify-center gap-2 bg-white border-2 border-pink-300 text-pink-600 font-semibold px-4 py-2.5 rounded-xl hover:bg-pink-50 transition text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Ver en Google Maps
                        </a>
                    </div>
                </div>

                <!-- Mapa embebido -->
                <div class="rounded-2xl overflow-hidden shadow-xl h-80 md:h-full min-h-72">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.591816298953!2d-75.2934609!3d2.933014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b7376ae7a8523%3A0x8bc39bf47c598f8a!2sSofia%20Florister%C3%ADa%20Neiva!5e0!3m2!1ses-419!2sco!4v1772380274738!5m2!1ses-419!2sco"
                        width="100%"
                        height="100%"
                        style="border:0; min-height: 320px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Ubicación Sofía Floristería Neiva - Cl. 16 #2-48 Los Potros">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Llamado a Acción WhatsApp -->
    <section class="py-12 md:py-20 bg-gradient-to-r from-pink-100 to-purple-100">
        <div class="container mx-auto px-4 text-center max-w-3xl">
            <h2 class="text-3xl md:text-5xl font-bold text-gray-800 mb-6">¿Listo para hacer tu pedido?</h2>
            <p class="text-base md:text-xl text-gray-600 mb-8 leading-relaxed px-4">
                Estamos listos para ayudarte a sorprender con flores. Escríbenos por WhatsApp y te atenderemos de inmediato.
            </p>
            <a href="https://wa.me/573177261647?text=Hola,%20quiero%20hacer%20un%20pedido%20de%20flores"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-3 bg-green-500 text-white px-6 md:px-8 py-3 md:py-4 rounded-lg text-base md:text-lg font-bold hover:bg-green-600 transition shadow-lg hover:shadow-xl">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                <span class="hidden sm:inline">Contactar por WhatsApp</span>
                <span class="sm:hidden">WhatsApp</span>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-700 text-white py-8 md:py-12">
        <div class="container mx-auto px-4 md:px-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Logo y descripción -->
                <div class="flex flex-col items-start">
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Sofía Floristería</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Flores que hacen inolvidables tus momentos más especiales.
                    </p>
                </div>

                <!-- Navegación -->
                <div class="flex flex-col items-start md:ml-8">
                    <h4 class="text-base md:text-lg font-bold mb-4">Navegación</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition text-sm">Inicio</a></li>
                        <li><a href="#catalogo" class="text-gray-300 hover:text-white transition text-sm">Productos</a></li>
                        <li><a href="{{ route('catalog') }}" class="text-gray-300 hover:text-white transition text-sm">Categorías</a></li>
                    </ul>
                </div>

                <!-- Contacto -->
                <div class="flex flex-col items-start md:ml-8">
                    <h4 class="text-base md:text-lg font-bold mb-4">Contacto</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <a href="mailto:fraysury18@gmail.com" class="hover:text-white transition break-all">fraysury18@gmail.com</a>
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

                <!-- Redes Sociales y Métodos de Pago -->
                <div class="flex flex-col items-start md:ml-8">
                    <h4 class="text-base md:text-lg font-bold mb-4">Síguenos</h4>
                    <div class="flex flex-col gap-3 mb-6">
                        <a href="https://web.facebook.com/people/Floristería-Sofía/100064982413493/"
                           target="_blank"
                           rel="noopener noreferrer"
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
                           rel="noopener noreferrer"
                           class="flex items-center gap-3 text-gray-300 hover:text-white transition group">
                            <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center group-hover:bg-gradient-to-br group-hover:from-purple-600 group-hover:via-pink-600 group-hover:to-orange-600 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold">Instagram</span>
                        </a>
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="mt-4 flex flex-col items-start">
                        <h4 class="text-base md:text-lg font-bold mb-4">Métodos de Pago</h4>
                        <div class="bg-white rounded-lg p-4 shadow-lg">
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Nequi -->
                                <div class="flex items-center justify-center p-2 bg-gray-50 rounded">
                                    <img src="{{ asset('images/nequi.png') }}" 
                                         alt="Nequi" 
                                         class="h-8 w-auto object-contain">
                                </div>
                                <!-- Daviplata -->
                                <div class="flex items-center justify-center p-2 bg-gray-50 rounded">
                                    <img src="{{ asset('images/daviplata.png') }}" 
                                         alt="Daviplata" 
                                         class="h-8 w-auto object-contain">
                                </div>
                                <!-- Transferencia -->
                                <div class="flex items-center justify-center p-2 bg-gray-50 rounded col-span-2">
                                    <svg class="w-8 h-8 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                    </svg>
                                    <span class="ml-2 text-sm font-semibold text-gray-700">Transferencia</span>
                                </div>
                                <!-- Efectivo -->
                                <div class="flex items-center justify-center p-2 bg-gray-50 rounded col-span-2">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                    </svg>
                                    <span class="ml-2 text-sm font-semibold text-gray-700">Efectivo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-black mt-8 pt-6">
                <p class="text-center text-gray-400 text-sm">
                    © 2026 Sofía Floristería. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('active');
        });

        closeMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mobileMenu.classList.remove('active');
            }
        });

        // Carousel navigation
        const carousel = document.getElementById('flowerCarousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        if (carousel && prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                carousel.scrollBy({
                    left: -320,
                    behavior: 'smooth'
                });
            });

            nextBtn.addEventListener('click', () => {
                carousel.scrollBy({
                    left: 320,
                    behavior: 'smooth'
                });
            });
        }

        // Accordion toggle function
        function toggleAccordion(index) {
            const content = document.getElementById(`content-${index}`);
            const icon = document.getElementById(`icon-${index}`);

            content.classList.toggle('active');
            icon.classList.toggle('rotate-180');
        }
    </script>

    <!-- Schema.org JSON-LD Structured Data for Local Business SEO -->
    <script type="application/ld+json">
    @verbatim
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Sofía Floristería",
      "image": "https://sofianeivafloristeria.com/images/logo.png",
      "@id": "https://sofianeivafloristeria.com",
      "url": "https://sofianeivafloristeria.com",
      "telephone": ["+57-317-726-1647", "+57-315-359-2689"],
      "priceRange": "$$",
      "email": "fraysury18@gmail.com",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Calle 16 # 2-48",
        "addressLocality": "Neiva",
        "addressRegion": "Huila",
        "postalCode": "",
        "addressCountry": "CO"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 2.9273,
        "longitude": -75.2819
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          "opens": "07:00",
          "closes": "19:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Sunday",
          "opens": "08:00",
          "closes": "12:00"
        }
      ],
      "sameAs": [
        "https://web.facebook.com/people/Floristería-Sofía/100064982413493/",
        "https://www.instagram.com/floristeriasofianeiva"
      ],
      "description": "Florería en Neiva con entrega rápida a domicilio. Arreglos florales para cumpleaños, amor y ocasiones especiales.",
      "paymentAccepted": ["Cash", "Bank Transfer", "Nequi", "Daviplata"],
      "currenciesAccepted": "COP",
      "areaServed": {
        "@type": "City",
        "name": "Neiva",
        "containedInPlace": {
          "@type": "AdministrativeArea",
          "name": "Huila"
        }
      }
    }
    @endverbatim
    </script>
</body>
</html>