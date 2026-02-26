<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explora nuestro catálogo completo de arreglos florales en Neiva. Flores naturales para cumpleaños, amor, condolencias y ocasiones especiales. Pedidos por WhatsApp.">
    <title>Catálogo - Sofía Floristería - Neiva | Arreglos Florales</title>

    <!-- Canonical URL -->
    <link rel="canonical" href="https://sofianeivafloristeria.com/catalogo">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sofianeivafloristeria.com/catalogo">
    <meta property="og:title" content="Catálogo - Sofía Floristería - Neiva">
    <meta property="og:description" content="Explora nuestro catálogo completo de arreglos florales en Neiva. Flores naturales para cumpleaños, amor, condolencias y ocasiones especiales.">
    <meta property="og:image" content="https://sofianeivafloristeria.com/images/logo.png">
    <meta property="og:locale" content="es_CO">
    <meta property="og:site_name" content="Sofía Floristería">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Catálogo - Sofía Floristería - Neiva">
    <meta name="twitter:description" content="Explora nuestro catálogo completo de arreglos florales en Neiva.">
    <meta name="twitter:image" content="https://sofianeivafloristeria.com/images/logo.png">

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
    @livewireStyles
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

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Mobile menu animation - ESTO ES LO QUE FALTABA */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-50">

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

    <!-- Componente Livewire del Catálogo -->
    @livewire('flower-catalog')

    <!-- Footer -->
    <footer class="bg-gray-700 text-white py-8 md:py-12">
        <div class="container mx-auto px-4 md:px-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Logo y descripción -->
                <div class="flex flex-col items-start">
                    <h3 class="text-xl md:text-2xl font-bold mb-4">Sofía Floristería - Neiva</h3>
                    <p class="text-gray-300 font-family-arial-sans text-sm leading-relaxed">
                        Flores que hacen inolvidables tus momentos más especiales.
                    </p>
                </div>

                <!-- Navegación -->
                <div class="flex flex-col items-start md:ml-8">
                    <h4 class="text-base md:text-lg font-bold mb-4">Navegación</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition text-sm">Inicio</a></li>
                        <li><a href="{{ route('catalog') }}" class="text-gray-300 hover:text-white transition text-sm">Catálogo</a></li>
                        <li><a href="{{ route('home') }}#catalogo" class="text-gray-300 hover:text-white transition text-sm">Productos Destacados</a></li>
                    </ul>
                </div>

                <!-- Contacto -->
                <div class="flex flex-col items-start md:ml-8">
                    <h4 class="text-base md:text-lg font-bold mb-4">Contacto</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <a href="mailto:fraysury18@gmail.com" class="hover:text-white transition break-all">fraysury18@gmail.com</a>
                        </li>
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <a href="tel:+573177261647" class="hover:text-white transition">+57 3177261647</a>
                        </li>
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            <a href="tel:+573153592689" class="hover:text-white transition">+57 3153592689</a>
                        </li>
                        <li class="flex items-start gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
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
                    <div class="mt-4">
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
            <div class="border-t border-gray-600 mt-8 pt-6">
                <p class="text-center text-gray-400 text-sm">
                    © 2026 Sofía Floristería Neiva. Todos los derechos reservados.
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
    </script>

    @livewireScripts

</body>
</html>