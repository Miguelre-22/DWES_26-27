<?php

declare(strict_types=1);

require __DIR__ . '/config/funciones.php';

$errores = [];
$destino = prepararDestino('png', $errores);

if ($destino === null) {
    echo implode(PHP_EOL, $errores), PHP_EOL;
    exit(1);
}

$base = pathinfo($destino['nombre'], PATHINFO_FILENAME);

echo 'Nombre:  ', $destino['nombre'], PHP_EOL;
echo 'Destino: ', $destino['destino'], PHP_EOL;
echo '32 hexadecimales: ', preg_match('/\A[a-f0-9]{32}\z/', $base) === 1 ? 'sí' : 'no', PHP_EOL;
echo 'Contiene el nombre original "portada": ', str_contains($destino['nombre'], 'portada') ? 'sí' : 'no', PHP_EOL;
