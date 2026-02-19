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
                        @if(count($cart) > 0)
                            <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                {{ count($cart) > 9 ? '9+' : count($cart) }}
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
                            @if(count($cart) > 0)
                                <span class="bg-pink-600 text-white text-xs font-bold rounded-full px-2 py-0.5">{{ count($cart) }}</span>
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

            @if(count($cart) > 0)

                <!-- Lista de ítems -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">

                    <!-- Cabecera (solo desktop) -->
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        <div class="col-span-5">Producto</div>
                        <div class="col-span-3 text-center">Cantidad</div>
                        <div class="col-span-3 text-right">Subtotal</div>
                        <div class="col-span-1"></div>
                    </div>

                    <!-- Ítems -->
                    @foreach($cart as $id => $item)
                    <div class="flex items-center gap-3 md:gap-4 p-4 md:p-5 border-b border-gray-100 last:border-0">

                        <!-- Foto -->
                        <div class="w-16 h-16 md:w-20 md:h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                            @if($item['photo'])
                                <img src="{{ asset('storage/' . $item['photo']) }}"
                                     alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-pink-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Nombre + precio unitario -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-800 text-sm md:text-base truncate">{{ $item['name'] }}</h3>
                            <p class="text-pink-600 font-semibold text-xs md:text-sm mt-0.5">
                                ${{ number_format($item['price'], 0, ',', '.') }} c/u
                            </p>
                            <p class="text-gray-400 text-xs mt-0.5">Stock disponible: {{ $item['stock'] }}</p>
                        </div>

                        <!-- Controles de cantidad -->
                        <div class="flex items-center gap-1">
                            <!-- Decrementar -->
                            <form method="POST" action="{{ route('cart.update', $id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                <button type="submit"
                                        class="w-8 h-8 rounded-full bg-gray-100 hover:bg-pink-100 text-gray-700 font-bold text-lg flex items-center justify-center transition {{ $item['quantity'] <= 1 ? 'opacity-40 cursor-not-allowed' : '' }}"
                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                    −
                                </button>
                            </form>

                            <span class="w-8 text-center font-bold text-gray-800 text-sm select-none">
                                {{ $item['quantity'] }}
                            </span>

                            <!-- Incrementar -->
                            <form method="POST" action="{{ route('cart.update', $id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                <button type="submit"
                                        class="w-8 h-8 rounded-full bg-gray-100 hover:bg-pink-100 text-gray-700 font-bold text-lg flex items-center justify-center transition {{ $item['quantity'] >= $item['stock'] ? 'opacity-40 cursor-not-allowed' : '' }}"
                                        {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }}>
                                    +
                                </button>
                            </form>
                        </div>

                        <!-- Subtotal -->
                        <div class="text-right w-24 flex-shrink-0">
                            <span class="font-bold text-gray-800 text-sm md:text-base">
                                ${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Eliminar ítem -->
                        <form method="POST" action="{{ route('cart.remove', $id) }}">
                            @csrf
                            <button type="submit"
                                    class="text-red-400 hover:text-red-600 transition p-1 rounded-lg hover:bg-red-50"
                                    title="Eliminar del carrito">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <!-- Resumen del pedido -->
                <div class="bg-white rounded-xl shadow-md p-5 md:p-6 mb-6">
                    <div class="flex justify-between items-center text-lg md:text-xl font-bold">
                        <span class="text-gray-700">Total del pedido:</span>
                        <span class="text-pink-600 text-2xl">${{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">* Precios en pesos colombianos (COP). El precio de envío se confirma por WhatsApp.</p>
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <!-- Vaciar carrito -->
                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        <button type="submit"
                                class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-3 border-2 border-red-300 text-red-500 rounded-xl hover:bg-red-50 transition font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Vaciar carrito
                        </button>
                    </form>

                    <!-- Pedir por WhatsApp -->
                    <a href="{{ $whatsappUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex-1 flex items-center justify-center gap-3 bg-green-500 text-white px-6 py-3 rounded-xl hover:bg-green-600 transition font-bold text-base shadow-lg hover:shadow-xl">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Enviar pedido por WhatsApp
                    </a>
                </div>

            @else
                <!-- Carrito vacío -->
                <div class="bg-white rounded-xl shadow-md p-12 md:p-20 text-center">
                    <svg class="w-20 h-20 md:w-28 md:h-28 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-700 mb-3">Tu carrito está vacío</h2>
                    <p class="text-gray-400 text-sm md:text-base mb-8">
                        Explora nuestro catálogo y agrega las flores que más te gusten.
                    </p>
                    <a href="{{ route('catalog') }}"
                       class="inline-flex items-center gap-2 bg-pink-500 text-white px-7 py-3 rounded-xl hover:bg-pink-600 transition font-bold shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2l2 4h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                        </svg>
                        Ver catálogo de flores
                    </a>
                </div>
            @endif

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
