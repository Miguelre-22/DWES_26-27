<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

function noEncontrado(): never
{
    http_response_code(404);
    exit;
}

$nombre = $_GET['nombre'] ?? null;
if (!is_string($nombre) || !nombrePortadaValido($nombre)) {
    noEncontrado();
}

$ruta = DIRECTORIO_PORTADAS . '/' . $nombre;
if (!is_file($ruta)) {
    noEncontrado();
}

$mime = detectarMime($ruta);
if ($mime === false || !isset(MIMES_PERMITIDOS[$mime])) {
    noEncontrado();
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile($ruta);
exit;
