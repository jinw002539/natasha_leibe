<?php
    const RAIZ = __DIR__ . '/..';
    const EXT  = ['jpg', 'jpeg', 'png', 'webp'];

    function e(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }

    function asset(string $caminho): string
    {
        $f = RAIZ . '/assets/' . $caminho;
        return 'assets/' . $caminho . '?v=' . (is_file($f) ? filemtime($f) : 1);
    }

    function url(string $p = 'inicio', array $q = []): string
    {
        $q = ($p === 'inicio' ? [] : ['p' => $p]) + $q;
        return 'index.php' . ($q ? '?' . http_build_query($q) : '');
    }

    /** URL de uma fotografia redimensionada (rel = caminho dentro de /imagens). */
    function img(string $rel, int $w = 800): string
    {
        static $gd = null;
        $gd ??= function_exists('imagecreatetruecolor');
        if (!$gd) {
            return 'imagens/' . implode('/', array_map('rawurlencode', explode('/', $rel)));
        }
        return 'thumb.php?f=' . rawurlencode($rel) . '&w=' . $w;
    }

    /** Fotografias de uma pasta (não recursivo), por ordem natural. */
    function imagens_dir(string $rel): array
    {
        $rel = trim($rel, '/');
        $dir = RAIZ . '/imagens/' . $rel;
        if (!is_dir($dir)) { return []; }
        $out = [];
        foreach (scandir($dir) as $f) {
            if ($f[0] === '.') { continue; }
            if (is_file("$dir/$f") && in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), EXT, true)) {
                $out[] = "$rel/$f";
            }
        }
        natcasesort($out);
        return array_values($out);
    }

    function titulo_pasta(string $nome): string
    {
        $t = trim(str_replace(['_', '-'], ' ', $nome));
        return mb_strtoupper(mb_substr($t, 0, 1)) . mb_substr($t, 1);
    }

    /** Álbuns = subpastas de /imagens/galeria. */
    function albuns(array $c): array
    {
        static $cache = null;
        if ($cache !== null) { return $cache; }
        $base = RAIZ . '/imagens/galeria';
        $lista = [];
        $pastas = is_dir($base) ? scandir($base) : [];
        natcasesort($pastas);
        foreach ($pastas as $d) {
            if ($d[0] === '.' || !is_dir("$base/$d")) { continue; }
            $fotos = imagens_dir("galeria/$d");
            if (!$fotos) { continue; }
            $cfg = $c['albuns'][$d] ?? [];
            $lista[$d] = [
                'slug'      => $d,
                'titulo'    => $cfg['titulo'] ?? titulo_pasta($d),
                'descricao' => $cfg['descricao'] ?? '',
                'capa'      => $cfg['capa'] ?? $fotos[0],
                'fotos'     => $fotos,
                'total'     => count($fotos),
            ];
        }
        return $cache = $lista;
    }

    /** Todas as fotografias da galeria (álbuns + soltas). */
    function todas_fotos(array $c): array
    {
        static $cache = null;
        if ($cache !== null) { return $cache; }
        $todas = imagens_dir('galeria');
        foreach (albuns($c) as $a) { $todas = array_merge($todas, $a['fotos']); }
        natcasesort($todas);
        return $cache = array_values($todas);
    }

    /** Fotografia de fundo para um item: a indicada, ou (se activo) uma da galeria. */
    function fundo(array $c, int $i, ?string $rel, int $passo = 5): ?string
    {
        if ($rel && is_file(RAIZ . '/imagens/' . $rel)) { return $rel; }
        if (!empty($c['fundo_automatico'])) {
            $t = todas_fotos($c);
            if ($t) { return $t[($i * $passo) % count($t)]; }
        }
        return null;
    }

    function controlos(): string
    {
        return <<<HTML
        <button class="seta seta-prev" aria-label="Anterior" type="button">
        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M10 2 4 8l6 6"/></svg>
        </button>
        <button class="seta seta-next" aria-label="Seguinte" type="button">
        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m6 2 6 6-6 6"/></svg>
        </button>
        <div class="barra" aria-hidden="true"><i></i></div>
        HTML;
    }

    function paginacao(int $total, int $por, int $atual, string $pagina, array $q): string
    {
        $paginas = (int) ceil($total / $por);
        if ($paginas < 2) { return ''; }
        $link = fn (int $n) => e(url($pagina, $q + ['pg' => $n]));

        $nums = array_unique(array_filter([1, $atual - 1, $atual, $atual + 1, $paginas], fn ($n) => $n >= 1 && $n <= $paginas));
        sort($nums);

        $h = '<nav class="paginacao" aria-label="Páginas">';
        $h .= $atual > 1 ? '<a href="' . $link($atual - 1) . '">Anterior</a>' : '<span class="off">Anterior</span>';
        $ant = 0;
        foreach ($nums as $n) {
            if ($n - $ant > 1) { $h .= '<span class="off">…</span>'; }
            $h .= $n === $atual
                ? '<span class="atual" aria-current="page">' . $n . '</span>'
                : '<a href="' . $link($n) . '">' . $n . '</a>';
            $ant = $n;
        }
        $h .= $atual < $paginas ? '<a href="' . $link($atual + 1) . '">Seguinte</a>' : '<span class="off">Seguinte</span>';
        return $h . '</nav>';
    }
