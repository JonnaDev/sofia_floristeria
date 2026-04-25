/**
 * Hero scroll-driven playback — efecto "Apple" / web-scrolling
 *
 * Pauta: skills/01-web-scrolling.md
 *
 * Comportamiento:
 *  - Desktop: el vídeo se reproduce (a su velocidad natural) mientras el usuario
 *    scrollea. Si el usuario se detiene, el vídeo pausa tras un pequeño idle.
 *    Al volver a scrollear, el vídeo continúa desde donde se quedó. Reproducción
 *    fluida, sin seek frame-a-frame → sin stutter ni "saltos" de keyframe.
 *  - Mobile táctil (o `prefers-reduced-motion`): autoplay loop silencioso lineal,
 *    igual que el hero antiguo en móvil.
 *  - CTAs: se revelan cuando el vídeo llega al 85% (o al `ended`). Una vez visibles
 *    se quedan fijos; no se ocultan aunque el usuario suba.
 *  - Hint "Desliza" se desvanece con el progreso del scroll en el hero.
 *
 * El IIFE comprueba la existencia de los elementos clave y termina silenciosamente
 * si no está en la página del welcome — seguro para incluir globalmente vía app.js.
 */
(() => {
    const wrapper = document.getElementById('hero-wrapper');
    const video   = document.getElementById('hero-video');
    const ctas    = document.getElementById('hero-ctas');
    const hint    = document.getElementById('scroll-hint');

    if (!wrapper || !video || !ctas) return;

    // Detección "mobile real" (táctil + viewport estrecho).
    // Evita falsos positivos en laptops con DevTools abierto a la derecha.
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

    // ── Desktop: scroll-driven playback ───────────────────────────────
    const IDLE_MS   = 220;   // ms sin scroll para pausar
    const LATCH_AT  = 0.85;  // revelar CTAs al 85% del vídeo

    let idleTimer = null;
    let latched   = false;

    video.muted = true;
    video.pause();
    video.currentTime = 0;

    const latchCTAs = () => {
        if (latched) return;
        latched = true;
        ctas.classList.add('revealed');
    };

    video.addEventListener('timeupdate', () => {
        if (!latched && video.duration && video.currentTime / video.duration >= LATCH_AT) {
            latchCTAs();
        }
    });
    video.addEventListener('ended', latchCTAs);

    window.addEventListener('scroll', () => {
        const rect   = wrapper.getBoundingClientRect();
        const inView = rect.bottom > 0 && rect.top < window.innerHeight;

        if (inView && !video.ended) {
            if (video.paused) {
                video.play().catch(() => { /* puede bloquearse sin gesto previo */ });
            }
            if (idleTimer) clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                if (!video.ended) video.pause();
            }, IDLE_MS);
        }

        // Hint "Desliza" se desvanece con el progreso
        if (hint) {
            const scrollable = wrapper.offsetHeight - window.innerHeight;
            if (scrollable > 0) {
                const progress = Math.max(0, Math.min(1, -rect.top / scrollable));
                hint.style.opacity = Math.max(0, 1 - progress * 4);
            }
        }
    }, { passive: true });
})();
