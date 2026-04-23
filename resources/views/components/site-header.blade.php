@props(['hero' => false])

<header id="main-header" @class(['over-hero' => $hero])>
    <nav class="max-w-[1400px] mx-auto px-4 md:px-6 py-3 md:py-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/logo.png') }}" alt="Sofía Floristería" class="h-14 md:h-16 w-auto drop-shadow-lg">
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium tracking-wide uppercase">
                <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                <a href="{{ route('catalog') }}" class="nav-link">Catálogo</a>
                <a href="{{ route('home') }}#catalogo" class="nav-link">Destacados</a>
                <a href="{{ route('home') }}#contacto" class="nav-link">Contacto</a>
                <a href="{{ route('cart') }}" class="relative nav-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-pink-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>
            </div>

            <div class="hidden md:flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-cta px-5 py-2 rounded-full text-sm font-semibold transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-cta px-5 py-2 rounded-full text-sm font-semibold transition">Iniciar sesión</a>
                    @endauth
                @endif
            </div>

            <button id="mobile-menu-btn" class="md:hidden nav-icon focus:outline-none" aria-label="Abrir menú">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>
</header>

{{-- Overlay del menú (fuera del header para evitar el containing block del backdrop-filter) --}}
<div id="mobile-menu-overlay" class="mobile-menu-overlay md:hidden"></div>

<div id="mobile-menu" class="mobile-menu md:hidden">
    <div class="p-6 h-full overflow-y-auto">
        <button id="close-menu-btn" class="absolute top-4 right-4 text-gray-600 p-1" aria-label="Cerrar menú">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="mt-12 flex flex-col gap-5 text-gray-700 font-medium">
            <a href="{{ route('home') }}" class="hover:text-pink-500 transition">Inicio</a>
            <a href="{{ route('catalog') }}" class="hover:text-pink-500 transition">Catálogo</a>
            <a href="{{ route('home') }}#catalogo" class="hover:text-pink-500 transition">Destacados</a>
            <a href="{{ route('home') }}#contacto" class="hover:text-pink-500 transition">Contacto</a>
            <a href="{{ route('cart') }}" class="flex items-center gap-2 hover:text-pink-500 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-4H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Carrito
                @php $cartCountMobile = count(session('cart', [])); @endphp
                @if($cartCountMobile > 0)
                    <span class="bg-pink-500 text-white text-xs font-bold rounded-full px-2 py-0.5">{{ $cartCountMobile }}</span>
                @endif
            </a>
            <hr class="border-gray-200 my-2">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-full text-center text-sm font-semibold hover:bg-pink-500 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-full text-center text-sm font-semibold hover:bg-pink-500 transition">Iniciar sesión</a>
                @endauth
            @endif
        </div>
    </div>
</div>

@once
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@300;400;500;600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Inter', system-ui, -apple-system, sans-serif; -webkit-font-smoothing: antialiased; }
    .font-serif-display { font-family: 'Playfair Display', Georgia, serif; }

    #main-header {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 50;
        background: rgba(255, 255, 255, 0.72);
        backdrop-filter: saturate(180%) blur(18px);
        -webkit-backdrop-filter: saturate(180%) blur(18px);
        border-bottom: 1px solid rgba(0,0,0,0.06);
        transition: background 0.4s ease, backdrop-filter 0.4s ease, border-color 0.4s ease;
        opacity: 0;
        animation: headerDrop 0.9s cubic-bezier(.2,.7,.3,1) both;
        animation-delay: 0.15s;
    }
    #main-header.is-loaded { opacity: 1; }

    #main-header.over-hero {
        background: rgba(255, 255, 255, 0);
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
        border-bottom-color: transparent;
    }
    #main-header.over-hero.scrolled {
        background: rgba(255, 255, 255, 0.72);
        backdrop-filter: saturate(180%) blur(18px);
        -webkit-backdrop-filter: saturate(180%) blur(18px);
        border-bottom-color: rgba(0,0,0,0.06);
    }

    #main-header .nav-link,
    #main-header .nav-icon {
        color: #374151;
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }
    #main-header.over-hero:not(.scrolled) .nav-link,
    #main-header.over-hero:not(.scrolled) .nav-icon {
        color: #ffffff;
        text-shadow: 0 1px 8px rgba(0,0,0,0.35);
    }
    #main-header .nav-link:hover { color: #ec4899; }

    #main-header .nav-cta {
        background: #111827; border: 1px solid #111827; color: #fff;
    }
    #main-header .nav-cta:hover { background: #ec4899; border-color: #ec4899; }
    #main-header.over-hero:not(.scrolled) .nav-cta {
        background: rgba(255,255,255,0.18);
        border-color: rgba(255,255,255,0.35);
        color: #fff;
        backdrop-filter: blur(8px);
    }

    @keyframes headerDrop {
        from { opacity: 0; transform: translateY(-14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Mobile menu: fuera del header → fixed respecto al viewport real */
    .mobile-menu {
        position: fixed;
        top: 0; right: 0;
        height: 100vh;
        width: 18rem;
        max-width: 85vw;
        background: #ffffff;
        box-shadow: -10px 0 40px rgba(0,0,0,0.15);
        z-index: 60;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
    }
    .mobile-menu.active { transform: translateX(0); }

    .mobile-menu-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 55;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .mobile-menu-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
</style>

<script>
(() => {
    const header = document.getElementById('main-header');
    if (header) {
        requestAnimationFrame(() => header.classList.add('is-loaded'));
        const onScroll = () => {
            if (window.scrollY > 60) header.classList.add('scrolled');
            else                     header.classList.remove('scrolled');
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }
    const btn     = document.getElementById('mobile-menu-btn');
    const close   = document.getElementById('close-menu-btn');
    const menu    = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-menu-overlay');

    const openMenu  = () => { menu?.classList.add('active');    overlay?.classList.add('active');    document.body.style.overflow = 'hidden'; };
    const closeMenu = () => { menu?.classList.remove('active'); overlay?.classList.remove('active'); document.body.style.overflow = ''; };

    if (btn && menu) {
        btn.addEventListener('click', (e) => { e.stopPropagation(); openMenu(); });
        close?.addEventListener('click', closeMenu);
        overlay?.addEventListener('click', closeMenu);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMenu(); });
        // Cerrar al clickear cualquier enlace del menú
        menu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
    }
})();
</script>
@endonce
