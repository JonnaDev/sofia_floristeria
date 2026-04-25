/**
 * Hero scroll-scrubbed video — efecto "Apple" / web-scrolling
 *
 * Pauta: skills/01-web-scrolling.md
 *
 * Comportamiento:
 *  - Desktop: el `currentTime` del vídeo se sincroniza con el progreso de scroll
 *    dentro de `#hero-wrapper`. El wrapper debe tener height grande (~500vh) para
 *    que el scroll recorra el vídeo con calma y se aprecien todos los fotogramas.
 *    Scroll hacia abajo → vídeo avanza fotograma a fotograma.
 *    Scroll hacia arriba → vídeo retrocede.
 *  - Mobile táctil o `prefers-reduced-motion`: fallback a autoplay loop silencioso.
 *  - CTAs: latched al cruzar el umbral (~92% del scroll). Una vez visibles,
 *    no se ocultan aunque el usuario suba.
 *  - Hint "Desliza" se desvanece al empezar a interactuar.
 *  - Si existe `#hero-progress-fill` (opcional), se actualiza su ancho con el progreso.
 *
 * El IIFE comprueba la existencia de los elementos clave y termina silenciosamente
 * si no está en la página del welcome — seguro para incluir globalmente vía app.js.
 */
(() => {
    const wrapper      = document.getElementById('hero-wrapper');
    const video        = document.getElementById('hero-video');
    const ctas         = document.getElementById('hero-ctas');
    const hint         = document.getElementById('scroll-hint');
    const progressFill = document.getElementById('hero-progress-fill');

    if (!wrapper || !video || !ctas) return;

    // Detección "mobile real" (táctil + viewport estrecho). Evita falsos positivos
    // en laptops con DevTools abierto a la derecha.
    const hasTouch      = ('ontouchstart' in window) || navigator.maxTouchPoints > 0;
    const narrowView    = window.matchMedia('(max-width: 768px)').matches;
    const isRealMobile  = hasTouch && narrowView;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Fallback: autoplay loop en mobile táctil o si el usuario pidió reducir movimiento
    if (isRealMobile || reducedMotion) {
        wrapper.style.height = '100vh';
        video.loop     = true;
        video.autoplay = true;
        video.play().catch(() => {});
        ctas.classList.add('revealed');
        if (hint) hint.style.display = 'none';
        return;
    }

    // Desktop: scroll-scrub
    const LATCH_THRESHOLD = 0.92;

    let duration = 0;
    let ticking  = false;
    let latched  = false;

    const ready = () => {
        duration = video.duration || 0;
        update();
    };

    video.pause();
    video.currentTime = 0;

    if (video.readyState >= 1) {
        ready();
    } else {
        video.addEventListener('loadedmetadata', ready);
        video.load();
    }

    function update() {
        if (!duration) return;

        const rect       = wrapper.getBoundingClientRect();
        const scrollable = wrapper.offsetHeight - window.innerHeight;
        if (scrollable <= 0) return;

        const progress = Math.max(0, Math.min(1, -rect.top / scrollable));
        const target   = progress * (duration - 0.05);

        try { video.currentTime = target; } catch (e) { /* seek en curso */ }

        if (!latched && progress >= LATCH_THRESHOLD) {
            latched = true;
            ctas.classList.add('revealed');
        }

        if (hint)         hint.style.opacity       = Math.max(0, 1 - progress * 4);
        if (progressFill) progressFill.style.width = (progress * 100) + '%';
    }

    window.addEventListener('scroll', () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
            update();
            ticking = false;
        });
    }, { passive: true });

    window.addEventListener('resize', update);
})();
