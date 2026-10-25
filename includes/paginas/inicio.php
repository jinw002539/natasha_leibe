<?php
$itens = ['mensagens', 'poemas', 'galeria'];
?>
<section class="grid h-[100svh] min-h-[560px] grid-rows-3 md:grid-rows-1 md:grid-cols-3">
  <?php foreach ($itens as $i => $k):
      $capa = fundo($c, $i, $c['capas'][$k] ?? null, 7);
      $s = $c['secoes'][$k];
  ?>
    <a href="<?= e(url($k)) ?>" class="tile group relative block overflow-hidden border-b border-linho/10 md:border-b-0 md:border-r">
      <?php if ($capa): ?>
        <img class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1600ms] ease-out group-hover:scale-105"
             src="<?= e(img($capa, 1200)) ?>" alt="" <?= $i ? 'loading="lazy"' : '' ?> decoding="async">
      <?php else: ?>
        <div class="absolute inset-0 hero-vazio"></div>
      <?php endif; ?>
      <div class="absolute inset-0 bg-noite/35 transition-colors duration-700 group-hover:bg-noite/15"></div>
      <div class="veil veil-hero"></div>
      <div class="absolute inset-x-0 bottom-0 z-20 px-6 md:px-10 pb-6 md:pb-14">
        <h2 class="font-serif font-light leading-none text-[clamp(2.4rem,6vw,4.6rem)]"><?= e($s['titulo']) ?></h2>
        <p class="mt-3 max-w-xs text-sm md:text-base opacity-85"><?= e($s['descricao']) ?></p>
        <span class="tile-linha mt-5 block h-px w-10 bg-ouro transition-all duration-700 group-hover:w-24"></span>
      </div>
    </a>
  <?php endforeach; ?>
</section>
