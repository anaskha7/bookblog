</main>

<!-- FOOTER -->
<footer class="bg-white border-t border-[#E7E5E4] py-12">
    <div class="max-w-[1400px] mx-auto px-6 grid md:grid-cols-4 gap-8">
        <div class="col-span-1 md:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <span class="font-serif font-bold text-xl text-theme-text">BookBlog.</span>
            </div>
            <p class="text-theme-muted text-sm leading-relaxed max-w-sm">
                Un espacio dedicado a la literatura, donde cada libro tiene su propia historia más allá de las páginas.
            </p>
        </div>
        <div>
            <h5 class="font-bold mb-4 text-theme-text">Enlaces</h5>
            <ul class="space-y-2 text-sm text-theme-muted">
                <li><a href="<?= BASE_URL ?>" class="hover:text-theme-primary transition-colors">Inicio</a></li>

                <li><a href="#" class="hover:text-theme-primary transition-colors">Sobre Nosotros</a></li>
            </ul>
        </div>
        <div>
            <h5 class="font-bold mb-4 text-theme-text">Síguenos</h5>
            <div class="flex gap-4">
                <a href="#"
                    class="w-10 h-10 rounded-full bg-[#F5F5F4] flex items-center justify-center text-theme-text hover:bg-theme-primary hover:text-white transition-colors"><i
                        class="fab fa-twitter"></i></a>
                <a href="#"
                    class="w-10 h-10 rounded-full bg-[#F5F5F4] flex items-center justify-center text-theme-text hover:bg-theme-primary hover:text-white transition-colors"><i
                        class="fab fa-instagram"></i></a>
                <a href="#"
                    class="w-10 h-10 rounded-full bg-[#F5F5F4] flex items-center justify-center text-theme-text hover:bg-theme-primary hover:text-white transition-colors"><i
                        class="fab fa-github"></i></a>
            </div>
        </div>
    </div>
    <div class="max-w-[1400px] mx-auto px-6 mt-12 pt-8 border-t border-[#F5F5F4] text-center text-xs text-theme-muted">
        &copy; <?= date('Y') ?> BookBlog Project. Todos los derechos reservados.
    </div>
</footer>
</body>

</html>