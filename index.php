<?php
    require __DIR__ . '/includes/helpers.php';

    $c = require __DIR__ . '/config/conteudo.php';

    $paginas = ['inicio', 'mensagens', 'poemas', 'galeria'];
    $pagina  = $_GET['p'] ?? 'inicio';
    if (!in_array($pagina, $paginas, true)) {
        http_response_code(404);
        $pagina = 'inicio';
    }

    // Páginas de ecrã inteiro (sem rodapé, sem scroll da página)
    $tela_cheia = in_array($pagina, ['mensagens', 'poemas'], true);

    require __DIR__ . '/includes/header.php';
    require __DIR__ . "/includes/paginas/$pagina.php";
    require __DIR__ . '/includes/footer.php';
?>