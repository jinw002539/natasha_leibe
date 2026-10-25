<?php $total = count($c['poemas']); ?>
<section class="relative h-[100svh] w-full overflow-hidden">
  <div class="swiper swiper-tela swiper-poemas h-full" data-contador="#contador">
    <div class="swiper-wrapper">
      <?php foreach ($c['poemas'] as $i => $p):
          $bg     = fundo($c, $i, $p['imagem'] ?? null, 4);
          $layout = ($p['layout'] ?? 'fundo') === 'topo' ? 'topo' : 'fundo';
          $dur    = !empty($p['duracao']) ? ' data-swiper-autoplay="' . (int) $p['duracao'] . '"' : '';
      ?>
        <div class="swiper-slide"<?= $dur ?>>
        <?php if ($layout === 'fundo'): ?>
          <div class="relative h-full w-full">
            <?php if ($bg): ?>
              <img class="kenburns absolute inset-0 h-full w-full object-cover" src="<?= e(img($bg, 1800)) ?>" alt="" <?= $i ? 'loading="lazy"' : '' ?> decoding="async">
            <?php else: ?>
              <div class="absolute inset-0 hero-vazio"></div>
            <?php endif; ?>
            <div class="absolute inset-0 scrim-poema"></div>
            <div class="rolagem relative z-10 flex h-full overflow-y-auto px-6 md:px-24 pt-24 pb-28">
              <?php include __DIR__ . '/_poema.php'; ?>
            </div>
          </div>
        <?php else: ?>
          <div class="flex h-full flex-col bg-noite">
            <div class="relative h-[40svh] md:h-[46svh] shrink-0 overflow-hidden">
              <?php if ($bg): ?>
                <img class="kenburns absolute inset-0 h-full w-full object-cover" src="<?= e(img($bg, 1800)) ?>" alt="" <?= $i ? 'loading="lazy"' : '' ?> decoding="async">
              <?php else: ?>
                <div class="absolute inset-0 hero-vazio"></div>
              <?php endif; ?>
              <div class="veil veil-hero"></div>
            </div>
            <div class="rolagem flex flex-1 overflow-y-auto px-6 md:px-24 pb-28">
              <?php include __DIR__ . '/_poema.php'; ?>
            </div>
          </div>
        <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?= controlos() ?>
    <p id="contador" class="contador" aria-live="polite">1 / <?= $total ?></p>

    <button id="indice-btn" class="indice-btn" type="button" aria-expanded="false" aria-controls="indice">Índice</button>
    <div id="indice" class="indice" aria-hidden="true">
      <ul>
        <?php foreach ($c['poemas'] as $i => $p): ?>
          <li><button type="button" data-ir="<?= $i ?>"><?= e($p['titulo']) ?></button></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
