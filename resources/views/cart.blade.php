<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tu carrito de compras en Sofía Floristería - Neiva. Revisa tus productos y haz tu pedido por WhatsApp.">
    <title>Carrito - Sofía Floristería - Neiva</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .mobile-menu { transform: translateX(100%); transition: transform 0.3s ease-in-out; }
        .mobile-menu.active { transform: translateX(0); }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/logo.png') }}" alt="Sofía Floristería" class="h-16 md:h-20 w-auto drop-shadow-lg">
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

    <!-- Contenido principal del carrito -->
    <main class="min-h-screen py-8 md:py-12">
        <div class="container mx-auto px-4 max-w-4xl">

            <!-- Encabezado de página -->
            <div class="flex items-center justify-between mb-6 md:mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Mi Carrito</h1>
                <a href="{{ route('catalog') }}"
                   class="flex items-center gap-1 text-pink-500 hover:text-pink-600 transition text-sm font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Continuar comprando
                </a>
            </div>

            @livewire('cart')

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-700 text-white py-8 md:py-12 mt-8">
        <div class="container mx-auto px-4 md:px-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="flex flex-col items-start">
                    <h3 class="text-xl font-bold mb-4">Sofía Floristería</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">Flores que hacen inolvidables tus momentos más especiales.</p>
                </div>
                <div class="flex flex-col items-start">
                    <h4 class="text-base font-bold mb-4">Navegación</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition text-sm">Inicio</a></li>
                        <li><a href="{{ route('catalog') }}" class="text-gray-300 hover:text-white transition text-sm">Catálogo</a></li>
                        <li><a href="{{ route('cart') }}" class="text-gray-300 hover:text-white transition text-sm">Carrito</a></li>
                    </ul>
                </div>
                <div class="flex flex-col items-start">
                    <h4 class="text-base font-bold mb-4">Contacto</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <a href="tel:+573177261647" class="hover:text-white transition">+57 3177261647</a>
                        </li>
                        <li class="flex items-start gap-2 text-gray-300 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Calle 16 # 2-48, Neiva - Huila</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-600 pt-6">
                <p class="text-center text-gray-400 text-sm">© 2026 Sofía Floristería Neiva. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn  = document.getElementById('close-menu-btn');
        const mobileMenu    = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => mobileMenu.classList.add('active'));
        closeMenuBtn.addEventListener('click',  () => mobileMenu.classList.remove('active'));
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mobileMenu.classList.remove('active');
            }
        });
    </script>

</body>
</html>
