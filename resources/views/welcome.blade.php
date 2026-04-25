<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Florería en Neiva con entrega rápida a domicilio. Arreglos florales para cumpleaños, amor y ocasiones especiales. Compra fácil por WhatsApp.">
    <title>Sofía Floristería - Neiva | Flores a Domicilio</title>

    <link rel="canonical" href="https://sofianeivafloristeria.com/">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sofianeivafloristeria.com/">
    <meta property="og:title" content="Sofía Floristería - Neiva | Flores a Domicilio">
    <meta property="og:description" content="Florería en Neiva con entrega rápida a domicilio. Arreglos florales para cumpleaños, amor y ocasiones especiales. Compra fácil por WhatsApp.">
    <meta property="og:image" content="https://sofianeivafloristeria.com/images/logo.WebP">
    <meta property="og:locale" content="es_CO">
    <meta property="og:site_name" content="Sofía Floristería">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sofía Floristería - Neiva | Flores a Domicilio">
    <meta name="twitter:description" content="Florería en Neiva con entrega rápida a domicilio. Arreglos florales para cumpleaños, amor y ocasiones especiales.">
    <meta name="twitter:image" content="https://sofianeivafloristeria.com/images/logo.WebP">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LTS541GNH5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-LTS541GNH5');
    </script>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preload" as="video" href="{{ asset('videos/hero.mp4') }}">
    <link rel="preload" as="image" href="{{ asset('images/hero-poster.webp') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Evita overflow horizontal en mobile (menú fijo fuera del viewport,
           transforms de reveal, etc). `clip` preserva position:sticky. */
        html, body { overflow-x: clip; }
        html { scroll-behavior: smooth; }
        body { background: #fafafa; color: #111827; }

        /* ---------------- Hero scroll-scrub ---------------- */
        #hero-wrapper { position: relative; }
        #hero-sticky {
            position: sticky; top: 0;
            height: 100vh; width: 100%;
            overflow: hidden;
            background: #0a0a0a;
        }
        #hero-video {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            will-change: contents;
        }
        #hero-gradient {
            position: absolute; inset: 0;
            background:
                linear-gradient(to bottom, rgba(0,0,0,0.25) 0%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 60%, rgba(0,0,0,0.65) 100%);
            pointer-events: none;
        }
        #hero-ctas {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            padding: 0 1.5rem;
            pointer-events: none;
        }
        #hero-ctas .hero-stagger > * {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.9s cubic-bezier(.2,.7,.3,1),
                        transform 0.9s cubic-bezier(.2,.7,.3,1);
        }
        #hero-ctas.revealed { pointer-events: auto; }
        #hero-ctas.revealed .hero-stagger > * { opacity: 1; transform: translateY(0); }
        #hero-ctas.revealed .hero-stagger > :nth-child(1) { transition-delay: 0s; }
        #hero-ctas.revealed .hero-stagger > :nth-child(2) { transition-delay: 0.18s; }
        #hero-ctas.revealed .hero-stagger > :nth-child(3) { transition-delay: 0.36s; }
        #hero-ctas.revealed .hero-stagger > :nth-child(4) { transition-delay: 0.54s; }
        #scroll-hint {
            position: absolute;
            bottom: 2rem; left: 50%;
            transform: translateX(-50%);
            color: rgba(255,255,255,0.75);
            font-size: 0.75rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            transition: opacity 0.4s ease;
        }
        #scroll-hint::after {
            content: '';
            display: block;
            width: 1px; height: 40px;
            margin: 0.75rem auto 0;
            background: linear-gradient(to bottom, rgba(255,255,255,0.9), transparent);
            animation: scrollBounce 2s ease-in-out infinite;
        }
        @keyframes scrollBounce {
            0%, 100% { transform: scaleY(0.4); transform-origin: top; }
            50%      { transform: scaleY(1);   transform-origin: top; }
        }

        /* ---------------- Reveal-on-scroll ---------------- */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.9s cubic-bezier(.2,.7,.3,1),
                        transform 0.9s cubic-bezier(.2,.7,.3,1);
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left  { transform: translateX(-50px); }
        .reveal-right { transform: translateX(50px); }
        .reveal-left.is-visible, .reveal-right.is-visible { transform: translateX(0); }

        /* ---------------- Carousel apple-style ---------------- */
        .flower-row { position: relative; }
        .flower-image-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            background: #e5e7eb;
        }
        .flower-image-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 1s cubic-bezier(.2,.7,.3,1);
        }
        .flower-row:hover .flower-image-wrap img { transform: scale(1.04); }
        .flower-info-card {
            background: rgba(17, 24, 39, 0.82);
            backdrop-filter: saturate(180%) blur(14px);
            -webkit-backdrop-filter: saturate(180%) blur(14px);
            border: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            border-radius: 1.25rem;
        }

        /* ---------------- Utilidades ---------------- */
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        .accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
        .accordion-content.active { max-height: 500px; }

        /* Preferencia de reducir movimiento */
        @media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1; transform: none; transition: none; }
            #scroll-hint::after { animation: none; }
        }
    </style>
</head>
<body>

    <x-site-header :hero="true" />

    <!-- ============ ERROR MODAL (acceso denegado) ============ -->
    @if(session('error'))
    <div id="errorModal" class="fixed inset-0 bg-black/60 z-[60] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md mx-4 p-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Acceso denegado</h3>
                <p class="text-gray-600 mb-6">{{ session('error') }}</p>
                <button onclick="document.getElementById('errorModal').remove()" class="bg-gray-900 text-white px-6 py-2.5 rounded-full hover:bg-pink-500 transition font-semibold">
                    Entendido
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- ============ HERO: VIDEO SCROLL-SCRUBBED ============ -->
    <section id="hero-wrapper" style="height: 100vh;">
        <div id="hero-sticky">
            <video id="hero-video"
                   muted playsinline preload="auto"
                   poster="{{ asset('images/hero-poster.webp') }}">
                <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
            </video>
            <div id="hero-gradient"></div>

            <div id="hero-ctas">
                <div class="hero-stagger text-center max-w-2xl">
                    <p class="text-white/80 text-xs tracking-[0.4em] uppercase mb-4">Floristería · Neiva</p>
                    <h1 class="font-serif-display text-4xl sm:text-5xl md:text-7xl font-light text-white mb-5 leading-tight">
                        Donde la tierra regala flores
                    </h1>
                    <p class="text-white/85 text-base md:text-lg mb-9 font-light max-w-lg mx-auto">
                        Arreglos naturales, entrega el mismo día en Neiva.
                    </p>
                    <div>
                        <a href="{{ route('catalog') }}"
                           class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 px-8 py-4 rounded-full font-semibold tracking-wide hover:bg-gray-100 transition shadow-xl">
                            Explora el catálogo
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div id="scroll-hint">Desliza</div>
        </div>
    </section>

    <!-- ============ CARRUSEL DESTACADOS (reveal-on-scroll) ============ -->
    <section id="catalogo" class="relative py-20 md:py-32 bg-gradient-to-b from-gray-50 via-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 md:px-8">

            <div class="text-center mb-16 md:mb-24 reveal">
                <p class="text-xs tracking-[0.4em] uppercase text-gray-500 mb-3">Selección del momento</p>
                <h2 class="font-serif-display text-4xl md:text-6xl font-light text-gray-900 mb-4">Arreglos más vendidos</h2>
                <div class="w-16 h-px bg-gray-300 mx-auto"></div>
            </div>

            @if($flowers->count() > 0)
                <div class="space-y-24 md:space-y-40">
                    @foreach($flowers as $i => $flower)
                        @php
                            $category = $flower->categories->first();
                            $imageLeft = $i % 2 === 0;
                        @endphp
                        <a href="{{ route('catalog') }}?category_id={{ $category?->id ?? '' }}#flores"
                           class="flower-row block group">

                            <div class="grid md:grid-cols-12 gap-6 md:gap-10 items-center">

                                <!-- Imagen -->
                                <div class="md:col-span-7 reveal {{ $imageLeft ? 'reveal-left md:order-1' : 'reveal-right md:order-2' }}">
                                    <div class="flower-image-wrap aspect-[4/3] shadow-2xl shadow-gray-900/10">
                                        @if($flower->photo_flower_url)
                                            <img src="{{ asset('storage/' . $flower->photo_flower_url) }}"
                                                 alt="{{ $flower->name }}"
                                                 loading="lazy">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                                <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Info card transparente -->
                                <div class="md:col-span-5 reveal {{ $imageLeft ? 'reveal-right md:order-2' : 'reveal-left md:order-1' }}">
                                    <div class="flower-info-card p-8 md:p-10">
                                        @if($category)
                                            <p class="text-xs tracking-[0.35em] uppercase text-white/60 mb-3">{{ $category->name }}</p>
                                        @endif
                                        <h3 class="font-serif-display text-2xl md:text-4xl font-light mb-5 leading-tight">{{ $flower->name }}</h3>
                                        <p class="text-white/75 text-sm md:text-base leading-relaxed mb-6 line-clamp-3">
                                            {{ $flower->description ?? 'Arreglo natural elaborado con flores frescas seleccionadas cada mañana.' }}
                                        </p>

                                        <div class="flex items-baseline gap-4 mb-6 pb-6 border-b border-white/10">
                                            <span class="text-3xl md:text-4xl font-light">${{ number_format($flower->price, 0, ',', '.') }}</span>
                                            <span class="text-sm text-white/50">· {{ $flower->stock }} disponibles</span>
                                        </div>

                                        <span class="inline-flex items-center gap-2 text-sm font-medium tracking-wide group-hover:gap-4 transition-all">
                                            Ver categoría
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-20 md:mt-32 reveal">
                    <a href="{{ route('catalog') }}"
                       class="inline-flex items-center gap-2 bg-gray-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-pink-500 transition shadow-lg">
                        Ver todos los arreglos
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-20 reveal">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"></path>
                    </svg>
                    <h3 class="font-serif-display text-2xl md:text-3xl font-light text-gray-700 mb-3">Sin arreglos disponibles por ahora</h3>
                    <p class="text-gray-500">Estamos preparando nuevos. Vuelve pronto.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- ============ POR QUÉ ELEGIRNOS ============ -->
    <section class="py-20 md:py-28 bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto px-4 md:px-8">
            <div class="text-center mb-14 md:mb-20 reveal">
                <p class="text-xs tracking-[0.4em] uppercase text-white/50 mb-3">Nuestro compromiso</p>
                <h2 class="font-serif-display text-4xl md:text-5xl font-light">Tres razones</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-16">
                <div class="reveal text-center">
                    <div class="w-14 h-14 mx-auto mb-6 flex items-center justify-center rounded-full border border-white/20">
                        <svg class="w-7 h-7 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C10.343 2 9 3.343 9 5c0 .552.224 1.052.586 1.414L12 8.828l2.414-2.414C14.776 6.052 15 5.552 15 5c0-1.657-1.343-3-3-3z"/>
                            <path d="M19.071 4.929c-1.562-1.562-4.095-1.562-5.657 0L12 6.343 10.586 4.93c-1.562-1.562-4.095-1.562-5.657 0s-1.562 4.095 0 5.657l7.071 7.07 7.071-7.07c1.562-1.562 1.562-4.095 0-5.657z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif-display text-xl md:text-2xl mb-3">100% Naturales</h3>
                    <p class="text-white/60 text-sm leading-relaxed max-w-xs mx-auto">Flores frescas seleccionadas cada mañana directamente del cultivador.</p>
                </div>
                <div class="reveal text-center">
                    <div class="w-14 h-14 mx-auto mb-6 flex items-center justify-center rounded-full border border-white/20">
                        <svg class="w-7 h-7 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 8h-3V4H3c-1.11 0-2 .89-2 2v11h2a3 3 0 003 3 3 3 0 003-3h6a3 3 0 003 3 3 3 0 003-3h2v-5l-3-4zM7.5 18.5A1.5 1.5 0 016 17a1.5 1.5 0 011.5-1.5A1.5 1.5 0 019 17a1.5 1.5 0 01-1.5 1.5z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif-display text-xl md:text-2xl mb-3">Entrega en Neiva</h3>
                    <p class="text-white/60 text-sm leading-relaxed max-w-xs mx-auto">Mismo día en el casco urbano. Coordinamos todo por WhatsApp.</p>
                </div>
                <div class="reveal text-center">
                    <div class="w-14 h-14 mx-auto mb-6 flex items-center justify-center rounded-full border border-white/20">
                        <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif-display text-xl md:text-2xl mb-3">Pedidos seguros</h3>
                    <p class="text-white/60 text-sm leading-relaxed max-w-xs mx-auto">Gestiona tu orden con total tranquilidad. Confirmación inmediata.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ REVIEWS ============ -->
    <section class="py-20 md:py-28 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 md:px-8">
            <div class="text-center mb-14 md:mb-20 reveal">
                <p class="text-xs tracking-[0.4em] uppercase text-gray-500 mb-3">Testimonios</p>
                <h2 class="font-serif-display text-4xl md:text-5xl font-light text-gray-900 mb-4">Lo que dicen quienes confían</h2>
                <div class="w-16 h-px bg-gray-300 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach([
                    ['María González', 'Cliente verificada', '"Las flores llegaron frescas y hermosas. Mi mamá lloró de la emoción. Totalmente recomendados."'],
                    ['Carlos Ramírez', 'Cliente verificado', '"Excelente servicio y atención. El arreglo superó mis expectativas. La entrega fue puntual y profesional."'],
                    ['Laura Martínez', 'Cliente verificada', '"Perfectos para sorprender a mi esposa en nuestro aniversario. La calidad es excepcional. ¡Volveré!"'],
                ] as $review)
                    <div class="reveal bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex gap-1 mb-4">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-700 leading-relaxed italic mb-6 text-sm md:text-base">{{ $review[2] }}</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-600 font-semibold text-sm">
                                {{ strtoupper(substr($review[0], 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $review[0] }}</p>
                                <p class="text-xs text-gray-500">{{ $review[1] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="py-20 md:py-28 bg-white">
        <div class="max-w-3xl mx-auto px-4 md:px-8">
            <div class="text-center mb-14 reveal">
                <p class="text-xs tracking-[0.4em] uppercase text-gray-500 mb-3">Preguntas frecuentes</p>
                <h2 class="font-serif-display text-4xl md:text-5xl font-light text-gray-900">Resolvemos tus dudas</h2>
            </div>

            <div class="space-y-3">
                @foreach([
                    ['¿Cómo es el proceso de entrega?', 'Coordinamos tu pedido por WhatsApp, la entrega se realiza en Neiva y áreas cercanas con tiempos estimados que se confirman al ordenar.'],
                    ['¿Qué medios de pago manejan?', 'Aceptamos transferencias, pagos por Nequi, Daviplata y efectivo.'],
                    ['¿Puedo hacer cambios en mi pedido?', 'Sí, puedes modificar tu pedido con mínimo 24 horas de anticipación a la entrega.'],
                    ['¿Hacen entregas fuera de Neiva?', 'Actualmente trabajamos principalmente en Neiva, pero puedes consultarnos por entregas en otras ciudades.'],
                    ['¿Cuáles son nuestros horarios de atención?', 'Estamos para servirte de lunes a sábado de 7:00 a.m. a 7:00 p.m. Domingos y festivos: 8:00 a.m. a 12:00 p.m.'],
                ] as $idx => $faq)
                    <div class="bg-gray-50 rounded-xl overflow-hidden reveal">
                        <button onclick="toggleAccordion('{{ $idx + 1 }}')"
                                class="w-full px-5 md:px-6 py-4 text-left flex justify-between items-center hover:bg-gray-100 transition">
                            <span class="font-medium text-gray-900 text-base pr-4">{{ $faq[0] }}</span>
                            <svg id="icon-{{ $idx + 1 }}" class="w-5 h-5 text-gray-500 transform transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="content-{{ $idx + 1 }}" class="accordion-content px-5 md:px-6">
                            <div class="pb-4 text-gray-600 text-sm md:text-base leading-relaxed">{{ $faq[1] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============ UBICACIÓN ============ -->
    <section id="contacto" class="py-20 md:py-28 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 md:px-8">
            <div class="text-center mb-14 reveal">
                <p class="text-xs tracking-[0.4em] uppercase text-gray-500 mb-3">Visítanos</p>
                <h2 class="font-serif-display text-4xl md:text-5xl font-light text-gray-900 mb-4">Encuéntranos</h2>
                <p class="text-gray-500">En el corazón de Neiva</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-stretch">
                <div class="flex flex-col gap-4 reveal reveal-left">
                    <div class="rounded-2xl overflow-hidden shadow-xl flex-1">
                        <img src="{{ asset('images/sofia_floristeria_negocio_fisico.webp') }}"
                             alt="Fachada Sofía Floristería Neiva"
                             class="w-full h-56 md:h-72 object-cover">
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-gray-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">Dirección</p>
                                    <p class="text-gray-600 text-sm">Cl. 16 #2-48, Los Potros<br>Neiva, Huila, Colombia</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-gray-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">Horario</p>
                                    <p class="text-gray-600 text-sm">Lun – Sáb: 7:00 a.m. – 7:00 p.m.</p>
                                    <p class="text-gray-600 text-sm">Dom y festivos: 8:00 a.m. – 12:00 p.m.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-gray-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">Teléfonos</p>
                                    <a href="tel:+573177261647" class="text-pink-500 hover:text-pink-600 text-sm block">+57 317 726 1647</a>
                                    <a href="tel:+573153592689" class="text-pink-500 hover:text-pink-600 text-sm block">+57 315 359 2689</a>
                                </div>
                            </div>
                        </div>
                        <a href="https://maps.app.goo.gl/3r3XP7KQhRvmH2PAA" target="_blank" rel="noopener noreferrer"
                           class="mt-5 w-full flex items-center justify-center gap-2 bg-gray-900 text-white font-semibold px-4 py-2.5 rounded-full hover:bg-pink-500 transition text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Ver en Google Maps
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl overflow-hidden shadow-xl h-80 md:h-auto min-h-[320px] reveal reveal-right">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.591816298953!2d-75.2934609!3d2.933014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b7376ae7a8523%3A0x8bc39bf47c598f8a!2sSofia%20Florister%C3%ADa%20Neiva!5e0!3m2!1ses-419!2sco!4v1772380274738!5m2!1ses-419!2sco"
                        width="100%" height="100%" style="border:0;"
                        allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Ubicación Sofía Floristería Neiva"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA WHATSAPP ============ -->
    <section class="py-20 md:py-28 bg-gray-900 text-white">
        <div class="max-w-3xl mx-auto px-4 md:px-8 text-center reveal">
            <p class="text-xs tracking-[0.4em] uppercase text-white/50 mb-4">¿Listo?</p>
            <h2 class="font-serif-display text-4xl md:text-6xl font-light mb-6 leading-tight">Tu pedido, en un mensaje</h2>
            <p class="text-white/70 text-base md:text-lg mb-10 leading-relaxed">
                Escríbenos por WhatsApp y coordinamos tu arreglo en minutos.
            </p>
            <a href="https://wa.me/573177261647?text=Hola,%20quiero%20hacer%20un%20pedido%20de%20flores"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-3 bg-[#25D366] text-white px-8 py-4 rounded-full text-base md:text-lg font-semibold hover:bg-[#20ba5a] transition shadow-lg hover:shadow-xl">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Contactar por WhatsApp
            </a>
        </div>
    </section>

    <x-site-footer />

    <!-- ============ SCRIPTS ============ -->
    <script>
        // ── Accordion FAQ ─────────────────────────────────────────────
        function toggleAccordion(id) {
            const content = document.getElementById(`content-${id}`);
            const icon    = document.getElementById(`icon-${id}`);
            content?.classList.toggle('active');
            icon?.classList.toggle('rotate-180');
        }

        // (La lógica del hero scroll-scrubbed vive en resources/js/hero.js,
        //  cargada vía Vite a través de resources/js/app.js)

        // ── Reveal-on-scroll (Intersection Observer) ───────────────────
        (() => {
            const elements = document.querySelectorAll('.reveal');
            if (!elements.length || !('IntersectionObserver' in window)) {
                elements.forEach(el => el.classList.add('is-visible'));
                return;
            }
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
            elements.forEach(el => io.observe(el));
        })();
    </script>

    <!-- Schema.org JSON-LD -->
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
