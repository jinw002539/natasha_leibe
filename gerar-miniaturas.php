<?php
    /** Uso (opcional): php gerar-miniaturas.php  — pré-gera todas as miniaturas. */
    require __DIR__ . '/includes/helpers.php';
    require __DIR__ . '/includes/miniaturas.php';

    if (PHP_SAPI !== 'cli') { 
        exit('Executar na linha de comandos.'); 
    }

    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(RAIZ . '/imagens', FilesystemIterator::SKIP_DOTS));
    $n = 0;
    foreach ($it as $ficheiro) {
        $ext = strtolower($ficheiro->getExtension());
        if (!in_array($ext, EXT, true)) { 
            continue; 
        }
        $rel = ltrim(str_replace('\\', '/', substr($ficheiro->getPathname(), strlen(realpath(RAIZ . '/imagens')))), '/');
        foreach (LARGURAS as $w) { 
            miniatura($rel, $w);
         }
        echo "OK  $rel\n";
        $n++;
    }
    echo "\n$n fotografias processadas.\n";
