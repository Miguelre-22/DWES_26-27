<?php

declare(strict_types=1);

require __DIR__ . '/config/funciones.php';

$casos = [
    'clave ausente' => null,
    'UPLOAD_ERR_NO_FILE' => ['name' => '', 'type' => '', 'tmp_name' => '', 'error' => UPLOAD_ERR_NO_FILE, 'size' => 0],
    'UPLOAD_ERR_OK' => ['name' => 'portada.png', 'type' => 'image/png', 'tmp_name' => '/tmp/phpA1b2C3', 'error' => UPLOAD_ERR_OK, 'size' => 1304],
    'UPLOAD_ERR_INI_SIZE' => ['name' => 'grande.jpg', 'type' => 'image/jpeg', 'tmp_name' => '', 'error' => UPLOAD_ERR_INI_SIZE, 'size' => 0],
    'UPLOAD_ERR_PARTIAL' => ['name' => 'portada.png', 'type' => 'image/png', 'tmp_name' => '', 'error' => UPLOAD_ERR_PARTIAL, 'size' => 0],
    'estructura incorrecta' => ['name' => ['a.png'], 'type' => ['image/png'], 'tmp_name' => ['/tmp/x'], 'error' => [0], 'size' => [10]],
];

foreach ($casos as $nombre => $archivo) {
    $errores = [];
    $estado = estadoRecepcion($archivo, $errores);
    echo str_pad($nombre, 24), $estado, isset($errores['portada']) ? ' -> ' . $errores['portada'] : '', PHP_EOL;
}
