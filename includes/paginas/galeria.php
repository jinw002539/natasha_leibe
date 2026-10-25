<?php
$todas   = todas_fotos($c);
$albuns  = albuns($c);
$slug    = $_GET['album'] ?? null;
$ver_todas = $slug === 'todas';
$album   = (!$ver_todas && $slug !== null && isset($albuns[$slug])) ? $albuns[$slug] : null;

if ($slug !== null && !$ver_todas && !$album) { http_response_code(404); }

if ($album || $ver_todas):
    $fotos  = $ver_todas ? $todas : $album['fotos'];
    $titulo = $ver_todas ? 'Todas as fotografias' : $album['titulo'];
    $desc   = $ver_todas ? '' : $album['descricao'];
    $por    = max(6, (int) $c['paginacao']);
    $pg     = max(1, (int) ($_GET['pg'] ?? 1));
    $pg     = min($pg, max(1, (int) ceil(count($fotos) / $por)));
    $pagina_fotos = array_slice($fotos, ($pg - 1) * $por, $por);
    $q      = ['album' => $ver_todas ? 'todas' : $album['slug']];
?>
<section class="px-4 md:px-12 pt-28 md:pt-36 pb-16 mx-auto max-w-[96rem]">
  <p class="mb-3 text-sm text-bruma"><a class="hover:text-linho transition-colors" href="<?= e(url('galeria')) ?>">Galeria</a></p>
  <h1 class="font-serif font-light leading-none text-[clamp(2.6rem,7vw,5rem)]"><?= e($titulo) ?></h1>
  <?php if ($desc): ?><p class="mt-4 max-w-xl opacity-85"><?= e($desc) ?></p><?php endif; ?>
  <p class="mt-3 text-sm text-bruma"><?= count($fotos) ?> fotografias<?= count($fotos) > $por ? ' · página ' . $pg : '' ?></p>

  <?php if (count($albuns) > 0): ?>
    <div class="chips" role="navigation" aria-label="Álbuns">
      <a class="chip <?= $ver_todas ? 'ativo' : '' ?>" href="<?= e(url('galeria', ['album' => 'todas'])) ?>">Todas</a>
      <?php foreach ($albuns as $a): ?>
        <a class="chip <?= (!$ver_todas && $album['slug'] === $a['slug']) ? 'ativo' : '' ?>" href="<?= e(url('galeria', ['album' => $a['slug']])) ?>"><?= e($a['titulo']) ?></a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6 gap-2 md:gap-3">
    <?php foreach ($pagina_fotos as $rel):
        $leg = $c['legendas'][$rel] ?? '';
    ?>
      <a href="<?= e(img($rel, 1800)) ?>" class="glightbox foto group relative block aspect-[4/5] overflow-hidden bg-ameixa"
         data-gallery="pagina" data-description="<?= e($leg) ?>">
        <img class="h-full w-full object-cover transition-transform duration-[1200ms] ease-out group-hover:scale-105"
             src="<?= e(img($rel, 480)) ?>" srcset="<?= e(img($rel, 480)) ?> 480w, <?= e(img($rel, 800)) ?> 800w"
             sizes="(min-width:1536px) 16vw, (min-width:1024px) 24vw, (min-width:640px) 32vw, 48vw"
             alt="<?= e($leg) ?>" loading="lazy" decoding="async">
        <?php if ($leg): ?>
          <span class="veil veil-foto"></span>
          <span class="absolute z-10 inset-x-3 bottom-2 font-serif italic text-base md:text-lg"><?= e($leg) ?></span>
        <?php endif; ?>
      </a>
    <?php endforeach; ?>
  </div>

  <?= paginacao(count($fotos), $por, $pg, 'galeria', $q) ?>
</section>

<?php else: ?>
<section class="px-4 md:px-12 pt-28 md:pt-36 pb-16 mx-auto max-w-[96rem]">
  <h1 class="font-serif font-light leading-none text-[clamp(2.6rem,7vw,5rem)]"><?= e($c['secoes']['galeria']['titulo']) ?></h1>
  <p class="mt-4 max-w-xl opacity-85"><?= e($c['secoes']['galeria']['descricao']) ?></p>
  <p class="mt-3 text-sm text-bruma"><?= count($todas) ?> fotografias em <?= count($albuns) ?> álbuns</p>

  <?php if ($albuns || $todas): ?>
    <div class="mt-10 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-5">
      <?php if ($todas): ?>
        <a href="<?= e(url('galeria', ['album' => 'todas'])) ?>" class="card group relative block aspect-[4/5] overflow-hidden bg-ameixa">
          <div class="absolute inset-0 hero-vazio"></div>
          <div class="veil veil-foto"></div>
          <div class="absolute inset-x-4 bottom-4 z-10">
            <h2 class="font-serif text-2xl md:text-3xl leading-tight">Todas</h2>
            <p class="text-xs md:text-sm text-linho/70"><?= count($todas) ?> fotografias</p>
          </div>
        </a>
      <?php endif; ?>
      <?php foreach ($albuns as $a): ?>
        <a href="<?= e(url('galeria', ['album' => $a['slug']])) ?>" class="card group relative block aspect-[4/5] overflow-hidden bg-ameixa">
          <img class="absolute inset-0 h-full w-full object-cover transition-transform duration-[1400ms] ease-out group-hover:scale-105"
               src="<?= e(img($a['capa'], 800)) ?>" alt="" loading="lazy" decoding="async">
          <div class="veil veil-foto"></div>
          <div class="absolute inset-x-4 bottom-4 z-10">
            <h2 class="font-serif text-2xl md:text-3xl leading-tight"><?= e($a['titulo']) ?></h2>
            <p class="text-xs md:text-sm text-linho/70"><?= $a['total'] ?> fotografias</p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="mt-16 max-w-lg font-serif text-2xl text-bruma">
      Cria pastas dentro de <em>imagens/galeria</em> (uma por álbum), coloca lá as fotografias e elas aparecem aqui.
    </p>
  <?php endif; ?>
</section>
<?php endif; ?>
