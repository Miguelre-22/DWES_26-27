<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/archivos.php';

$cartel = cartelValido($_GET['nombre'] ?? null);

if ($cartel === null) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $cartel['mime']);
header('X-Content-Type-Options: nosniff');
readfile($cartel['ruta']);
exit;