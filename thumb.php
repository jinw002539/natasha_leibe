<?php
    require __DIR__ . '/includes/miniaturas.php';

    $rel = (string) ($_GET['f'] ?? '');
    $w   = (int) ($_GET['w'] ?? 800);
    $f   = miniatura($rel, $w);

    if (!$f) {
        http_response_code(404);
        exit;
    }

    $mimes = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
    $mime  = $mimes[strtolower(pathinfo($f, PATHINFO_EXTENSION))] ?? 'image/jpeg';
    $mod   = filemtime($f);

    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=2592000, immutable');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $mod) . ' GMT');

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $mod) {
        http_response_code(304);
        exit;
    }
    header('Content-Length: ' . filesize($f));
    readfile($f);
?>