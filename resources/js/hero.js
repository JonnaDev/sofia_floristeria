/**
 * Hero scroll-gated playback — efecto "Apple"
 *
 * Pauta: skills/01-web-scrolling.md
 *
 * Comportamiento:
 *  - Desktop: al primer intento de scroll dentro del hero, el vídeo empieza a
 *    reproducirse a velocidad natural (1x, decode lineal, sin stutter) y el scroll
 *    del documento queda BLOQUEADO. Durante los ~8s del vídeo el usuario no puede
 *    avanzar más abajo. Al terminar el vídeo:
 *      · Se desbloquea el scroll.
 *      · Aparecen los CTAs con cascada escalonada.
 *      · El usuario continúa hacia el carrusel.
 *  - Mobile táctil (o `prefers-reduced-motion`): autoplay loop lineal, igual que
 *    el hero antiguo en móvil. Sin bloqueo de scroll.
 *  - Si el usuario llega con un hash en la URL (#catalogo, #contacto, etc.) o
 *    con scroll restaurado, se salta el gate y se muestra el hero con CTAs
 *    directamente — no queremos atrapar a nadie que no venga a la home.
 *
 * Se interceptan wheel, touchmove y keys de scroll para cubrir todos los
 * métodos de navegación vertical del navegador.
 */
(() => {
    const wrapper = document.getElementById('hero-wrapper');
    const video   = document.getElementById('hero-video');
    const ctas    = document.getElementById('hero-ctas');
    const hint    = document.getElementById('scroll-hint');

    if (!wrapper || !video || !ctas) return;

    const hasTouch      = ('ontouchstart' in window) || navigator.maxTouchPoints > 0;
    const narrowView    = window.matchMedia('(max-width: 768px)').matches;
    const isRealMobile  = hasTouch && narrowView;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ── Fallback móvil / reduced-motion: autoplay loop lineal ─────────
    if (isRealMobile || reducedMotion) {
        wrapper.style.height = '100vh';
        video.loop     = true;
        video.autoplay = true;
        video.play().catch(() => {});
        ctas.classList.add('revealed');
        if (hint) hint.style.display = 'none';
        return;
    }

    // ── Desktop: scroll-gated playback ────────────────────────────────
    let started  = false;
    let finished = false;

    video.muted = true;
    video.pause();
    video.currentTime = 0;

    const lockScroll = () => {
        document.documentElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';
    };
    const unlockScroll = () => {
        document.documentElement.style.overflow = '';
        document.body.style.overflow = '';
    };

    const finishPlayback = () => {
        if (finished) return;
        finished = true;
        unlockScroll();
        ctas.classList.add('revealed');
        if (hint) hint.style.opacity = '0';
    };

    const startPlayback = () => {
        if (started) return;
        started = true;
        lockScroll();
        const playPromise = video.play();
        if (playPromise && typeof playPromise.catch === 'function') {
            playPromise.catch(() => {
                // Si el navegador bloqueó el play (política de autoplay), libera
                // el scroll para no atrapar al usuario sin recurso.
                unlockScroll();
                started = false;
            });
        }
    };

    video.addEventListener('ended', finishPlayback);

    // ── Bypass del gate ───────────────────────────────────────────────
    //   Llegada con hash (#catalogo, #contacto) o scroll restaurado → saltar.
    const arrivedMidPage =
        (window.location.hash && window.location.hash.length > 1) ||
        window.scrollY > 50;

    if (arrivedMidPage) {
        finishPlayback();
        video.play().catch(() => {});
        return;
    }

    // ── Interceptar cualquier intento de scroll ───────────────────────
    const gate = (e) => {
        if (finished) return;
        e.preventDefault();
        if (!started) startPlayback();
    };

    const SCROLL_KEYS = [
        'ArrowDown', 'ArrowUp', 'PageDown', 'PageUp',
        'Home', 'End', ' ', 'Spacebar'
    ];

    window.addEventListener('wheel',     gate, { passive: false });
    window.addEventListener('touchmove', gate, { passive: false });
    window.addEventListener('keydown', (e) => {
        if (!finished && SCROLL_KEYS.includes(e.key)) {
            e.preventDefault();
            if (!started) startPlayback();
        }
    });
})();
