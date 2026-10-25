<?php
$lista = array_map(fn ($m) => is_array($m) ? $m : ['texto' => $m], $c['mensagens']);
$total = count($lista);
?>
<section class="relative h-[100svh] w-full overflow-hidden">
  <div class="swiper swiper-tela h-full" data-contador="#contador">
    <div class="swiper-wrapper">
      <?php foreach ($lista as $i => $m):
          $bg = fundo($c, $i, $m['imagem'] ?? null, 3);
      ?>
        <div class="swiper-slide relative">
          <?php if ($bg): ?>
            <img class="kenburns absolute inset-0 h-full w-full object-cover" src="<?= e(img($bg, 1800)) ?>" alt="" <?= $i ? 'loading="lazy"' : '' ?> decoding="async">
          <?php else: ?>
            <div class="absolute inset-0 hero-vazio"></div>
          <?php endif; ?>
          <div class="absolute inset-0 scrim-texto"></div>
          <div class="relative z-10 flex h-full items-center justify-center px-8 md:px-28 pt-24 pb-24">
            <p class="max-w-3xl text-center font-serif font-light leading-[1.15] text-[clamp(2.1rem,6vw,4.6rem)]"><?= e($m['texto']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <?= controlos() ?>
    <p id="contador" class="contador" aria-live="polite">1 / <?= $total ?></p>
  </div>
</section>
