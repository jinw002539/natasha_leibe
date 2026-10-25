<?php
  $nav = ['inicio' => 'Início', 'mensagens' => 'Mensagens', 'poemas' => 'Poemas', 'galeria' => 'Galeria'];
  $titulo_pag = $pagina === 'inicio' ? $c['titulo'] : $c['secoes'][$pagina]['titulo'] . ' — ' . $c['titulo'];
?>
<!DOCTYPE html>
<html lang="pt" class="scroll-smooth">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#16121d">
    <title><?= e($titulo_pag) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Figtree:wght@300;400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css">
    <script>
      tailwind.config = {
        theme: { extend: {
          colors: { noite: '#16121d', noite2: '#1f1928', ameixa: '#3a2740', linho: '#eee6df', bruma: '#a79cae', ouro: '#cfa98a' },
          fontFamily: { serif: ['Cormorant', 'Georgia', 'serif'], sans: ['Figtree', 'system-ui', 'sans-serif'] }
        } }
      }
    </script>
    <link rel="stylesheet" href="<?= asset('css/estilo.css') ?>">
  </head>
  <body class="bg-noite text-linho font-sans font-light antialiased leading-relaxed <?= $tela_cheia ? 'overflow-hidden' : '' ?>">

  <header id="topo" class="cabecalho fixed inset-x-0 top-0 z-40 flex items-center justify-between px-5 md:px-12 pb-4">
    <a href="<?= e(url()) ?>" class="font-serif text-2xl tracking-wide"><?= e($c['titulo']) ?></a>

    <nav class="hidden md:block" aria-label="Principal">
      <ul class="flex gap-10 text-sm tracking-wider">
        <?php foreach ($nav as $k => $nome): if ($k === 'inicio') continue; ?>
          <li><a class="nav-link <?= $pagina === $k ? 'ativo' : '' ?>" href="<?= e(url($k)) ?>" <?= $pagina === $k ? 'aria-current="page"' : '' ?>><?= e($nome) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <button id="menu-btn" class="md:hidden menu-btn" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="menu">
      <span></span><span></span>
    </button>
  </header>

  <div id="menu" class="menu md:hidden" aria-hidden="true">
    <ul>
      <?php foreach ($nav as $k => $nome): ?>
        <li><a href="<?= e(url($k)) ?>" class="<?= $pagina === $k ? 'ativo' : '' ?>"><?= e($nome) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>

  <main>
