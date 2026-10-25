    </main>

    <?php if (!$tela_cheia): ?>
    <footer class="px-5 py-16 text-center font-serif italic text-2xl text-bruma pb-[max(4rem,env(safe-area-inset-bottom))]">
      <?= e($c['assinatura']) ?>
    </footer>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js"></script>
    <script>window.REC = { intervalo: <?= (int) $c['intervalo'] ?> };</script>
    <script src="<?= asset('js/app.js') ?>"></script>
  </body>
</html>
