<?php

declare(strict_types=1);

require __DIR__ . '/config/funciones.php';

$temporal = tempnam(sys_get_temp_dir(), 'php');
copy(__DIR__ . '/pruebas/portada.png', $temporal);

$errores = [];
$destino = prepararDestino('png', $errores);

echo 'El temporal existe: ', file_exists($temporal) ? 'sí' : 'no', PHP_EOL;
echo 'is_uploaded_file: ', is_uploaded_file($temporal) ? 'true' : 'false', PHP_EOL;
echo 'move_uploaded_file: ', move_uploaded_file($temporal, $destino['destino']) ? 'true' : 'false', PHP_EOL;

unlink($temporal);
