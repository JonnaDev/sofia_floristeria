<footer class="bg-black text-white/70 py-14 md:py-16">
    <div class="max-w-6xl mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
            <div>
                <h3 class="font-serif-display text-xl text-white mb-3">Sofía Floristería</h3>
                <p class="text-sm leading-relaxed">Flores que hacen inolvidables tus momentos más especiales.</p>
            </div>
            <div>
                <h4 class="text-xs tracking-[0.3em] uppercase text-white/50 mb-4">Navegación</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Inicio</a></li>
                    <li><a href="{{ route('home') }}#catalogo" class="hover:text-white transition">Destacados</a></li>
                    <li><a href="{{ route('catalog') }}" class="hover:text-white transition">Catálogo</a></li>
                    <li><a href="{{ route('home') }}#contacto" class="hover:text-white transition">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs tracking-[0.3em] uppercase text-white/50 mb-4">Contacto</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="mailto:fraysury18@gmail.com" class="hover:text-white transition break-all">fraysury18@gmail.com</a></li>
                    <li><a href="tel:+573177261647" class="hover:text-white transition">+57 317 726 1647</a></li>
                    <li><a href="tel:+573153592689" class="hover:text-white transition">+57 315 359 2689</a></li>
                    <li>Calle 16 # 2-48, Neiva</li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs tracking-[0.3em] uppercase text-white/50 mb-4">Síguenos</h4>
                <div class="flex gap-3 mb-6">
                    <a href="https://web.facebook.com/people/Floristería-Sofía/100064982413493/" target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full border border-white/15 flex items-center justify-center hover:bg-white hover:text-black transition" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/floristeriasofianeiva" target="_blank" rel="noopener noreferrer"
                       class="w-10 h-10 rounded-full border border-white/15 flex items-center justify-center hover:bg-white hover:text-black transition" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
                <h4 class="text-xs tracking-[0.3em] uppercase text-white/50 mb-3">Pagos</h4>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/nequi.png') }}" alt="Nequi" class="h-6 w-auto bg-white rounded p-0.5">
                    <img src="{{ asset('images/daviplata.png') }}" alt="Daviplata" class="h-6 w-auto bg-white rounded p-0.5">
                    <span class="text-xs">· Transferencia · Efectivo</span>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 pt-6 text-center text-xs text-white/40">
            © 2026 Sofía Floristería Neiva. Todos los derechos reservados.
        </div>
    </div>
</footer>

<a href="https://wa.me/573177261647?text=Hola,%20me%20interesa%20hacer%20un%20pedido%20en%20Sof%C3%ADa%20Floriester%C3%ADa"
   target="_blank" rel="noopener noreferrer"
   aria-label="Contactar por WhatsApp"
   class="fixed bottom-5 right-5 md:bottom-8 md:right-8 z-30 group">
    <div class="w-14 h-14 md:w-16 md:h-16 bg-[#25D366] rounded-full shadow-lg shadow-green-500/40
                flex items-center justify-center
                hover:scale-110 hover:shadow-xl hover:shadow-green-500/50
                active:scale-95 transition-all duration-200">
        <svg class="w-8 h-8 md:w-9 md:h-9 text-white" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.857L.057 23.215a.75.75 0 00.921.921l5.356-1.476A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.692-.51-5.222-1.396l-.374-.217-3.878 1.069 1.07-3.878-.217-.374A9.945 9.945 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
        </svg>
    </div>
</a>
