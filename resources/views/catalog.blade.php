<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explora nuestro catálogo completo de arreglos florales en Neiva. Flores naturales para cumpleaños, amor, condolencias y ocasiones especiales. Pedidos por WhatsApp.">
    <title>Catálogo - Sofía Floristería - Neiva | Arreglos Florales</title>

    <link rel="canonical" href="https://sofianeivafloristeria.com/catalogo">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sofianeivafloristeria.com/catalogo">
    <meta property="og:title" content="Catálogo - Sofía Floristería - Neiva">
    <meta property="og:description" content="Explora nuestro catálogo completo de arreglos florales en Neiva. Flores naturales para cumpleaños, amor, condolencias y ocasiones especiales.">
    <meta property="og:image" content="https://sofianeivafloristeria.com/images/logo.png">
    <meta property="og:locale" content="es_CO">
    <meta property="og:site_name" content="Sofía Floristería">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Catálogo - Sofía Floristería - Neiva">
    <meta name="twitter:description" content="Explora nuestro catálogo completo de arreglos florales en Neiva.">
    <meta name="twitter:image" content="https://sofianeivafloristeria.com/images/logo.png">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LTS541GNH5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-LTS541GNH5');
    </script>

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

    <main class="pt-20 md:pt-24">
        <div id="flores"></div>
        @livewire('flower-catalog')
    </main>

    <x-site-footer />

    @livewireScripts

</body>
</html>
