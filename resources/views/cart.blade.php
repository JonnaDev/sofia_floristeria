<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tu carrito de compras en Sofía Floristería - Neiva. Revisa tus productos y haz tu pedido por WhatsApp.">
    <title>Carrito - Sofía Floristería - Neiva</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        html, body { overflow-x: clip; }
        html { scroll-behavior: smooth; }
        body { background: #f4f4f5; color: #111827; }
    </style>
</head>
<body>

    <x-site-header />

    <main class="pt-24 md:pt-28 pb-16">
        <div class="max-w-4xl mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-xs tracking-[0.3em] uppercase text-gray-500 mb-1">Tu selección</p>
                    <h1 class="font-serif-display text-3xl md:text-4xl font-light text-gray-900">Mi Carrito</h1>
                </div>
                <a href="{{ route('catalog') }}"
                   class="flex items-center gap-1.5 text-gray-600 hover:text-pink-500 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Continuar comprando
                </a>
            </div>

            @livewire('cart')
        </div>
    </main>

    <x-site-footer />

    @livewireScripts

</body>
</html>
