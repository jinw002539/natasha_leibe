<article class="m-auto w-full max-w-2xl py-4 text-center">
  <h3 class="mb-6 font-serif text-4xl md:text-5xl font-light"><?= e($p['titulo']) ?></h3>
  <?php foreach ($p['linhas'] as $linha): ?>
    <?php if ($linha === ''): ?>
      <div class="h-5"></div>
    <?php else: ?>
      <p class="font-serif font-light text-xl md:text-2xl leading-relaxed"><?= e($linha) ?></p>
    <?php endif; ?>
  <?php endforeach; ?>
</article>
