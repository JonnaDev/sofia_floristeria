/**
 * Hero loop simple — vídeo en bucle silenciado y CTA con entrada suave
 * desde arriba al cargar la página.
 *
 * Pauta: skills/01-web-scrolling.md
 */
(() => {
    const video = document.getElementById('hero-video');
    const ctas  = document.getElementById('hero-ctas');

    if (video) {
        video.muted    = true;
        video.loop     = true;
        video.autoplay = true;
        video.playsInline = true;
        video.play().catch(() => {});
    }

    if (ctas) {
        requestAnimationFrame(() => ctas.classList.add('revealed'));
    }
})();
