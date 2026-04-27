/**
 * Hero loop playback con reveal de CTAs al terminar la primera pasada.
 *
 * Pauta: skills/01-web-scrolling.md
 *
 * Comportamiento:
 *  - Desktop y mobile: el vídeo se reproduce en loop, silenciado, autoplay.
 *  - La primera vez que el vídeo llega al final ('ended' o currentTime cerca
 *    de duration), aparecen los CTAs con cascada escalonada y se oculta el
 *    indicador de "Desliza".
 *  - Si el navegador permite loop nativo, 'ended' no dispara — por eso usamos
 *    también 'timeupdate' como fallback para detectar el fin de la primera
 *    vuelta.
 *  - Respeta `prefers-reduced-motion`: muestra los CTAs inmediatamente y
 *    deja el vídeo en loop sin esperar.
 */
(() => {
    const wrapper = document.getElementById('hero-wrapper');
    const video   = document.getElementById('hero-video');
    const ctas    = document.getElementById('hero-ctas');
    const hint    = document.getElementById('scroll-hint');

    if (!wrapper || !video || !ctas) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    video.muted    = true;
    video.loop     = true;
    video.autoplay = true;
    video.playsInline = true;
    video.play().catch(() => {});

    const revealCtas = () => {
        ctas.classList.add('revealed');
        if (hint) hint.style.opacity = '0';
    };

    if (reducedMotion) {
        revealCtas();
        return;
    }

    let revealed = false;
    const markRevealed = () => {
        if (revealed) return;
        revealed = true;
        revealCtas();
    };

    // Loop nativo: 'ended' no se dispara. Detectamos el fin de la primera
    // pasada cuando currentTime se acerca a duration por primera vez.
    const onTimeUpdate = () => {
        if (!video.duration || isNaN(video.duration)) return;
        if (video.currentTime >= video.duration - 0.25) {
            markRevealed();
            video.removeEventListener('timeupdate', onTimeUpdate);
        }
    };

    video.addEventListener('timeupdate', onTimeUpdate);
    video.addEventListener('ended', markRevealed); // por si algún navegador no respeta loop
})();
