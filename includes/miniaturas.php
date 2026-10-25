<?php
/**
 * Geração de miniaturas (GD) com cache em /cache/thumbs.
 * Fotos de telemóvel têm vários MB: servir versões reduzidas torna o site rápido.
 */
const LARGURAS = [480, 800, 1200, 1800];

/** Devolve o caminho do ficheiro a servir (miniatura em cache ou original). */
function miniatura(string $rel, int $w): ?string
{
    $base = realpath(__DIR__ . '/../imagens');
    $orig = realpath($base . '/' . $rel);
    if (!$base || !$orig || strpos($orig, $base . DIRECTORY_SEPARATOR) !== 0 || !is_file($orig)) {
        return null;
    }
    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
        return null;
    }
    if (!in_array($w, LARGURAS, true)) {
        $w = 800;
    }

    $info = @getimagesize($orig);
    if (!$info) {
        return null;
    }
    if ($info[0] <= $w) {
        return $orig; // já é pequena
    }

    $dir = __DIR__ . '/../cache/thumbs';
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    $destino = $dir . '/' . md5($orig . filemtime($orig)) . '_' . $w . '.jpg';
    if (is_file($destino)) {
        return $destino;
    }

    @ini_set('memory_limit', '512M');
    $img = match ($ext) {
        'png'  => @imagecreatefrompng($orig),
        'webp' => @imagecreatefromwebp($orig),
        default => @imagecreatefromjpeg($orig),
    };
    if (!$img) {
        return $orig;
    }

    if (in_array($ext, ['jpg', 'jpeg'], true) && function_exists('exif_read_data')) {
        $ex = @exif_read_data($orig);
        $o  = $ex['Orientation'] ?? 1;
        $rodada = match ($o) { 3 => imagerotate($img, 180, 0), 6 => imagerotate($img, -90, 0), 8 => imagerotate($img, 90, 0), default => null };
        if ($rodada) { imagedestroy($img); $img = $rodada; }
    }

    $lw = imagesx($img);
    $lh = imagesy($img);
    $nh = (int) round($lh * $w / $lw);
    $novo = imagecreatetruecolor($w, $nh);
    imagefill($novo, 0, 0, imagecolorallocate($novo, 22, 18, 29));
    imagecopyresampled($novo, $img, 0, 0, 0, 0, $w, $nh, $lw, $lh);

    $tmp = $destino . '.' . getmypid() . '.tmp';
    imagejpeg($novo, $tmp, 82);
    imagedestroy($img);
    imagedestroy($novo);
    @rename($tmp, $destino);

    return is_file($destino) ? $destino : $orig;
}
