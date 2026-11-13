<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

$portadas = [
    '3f2a9c1e7b6d4058a1c2e3f4a5b6c7d8.png',
    '00000000000000000000000000000000.png',
    '../secreto.txt',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portadas</title>
</head>
<body>
    <?php foreach ($portadas as $nombre): ?>
        <figure>
            <img src="/portada.php?nombre=<?= e(rawurlencode($nombre)) ?>" alt="Portada" width="100">
            <figcaption><?= e($nombre) ?></figcaption>
        </figure>
    <?php endforeach; ?>
</body>
</html>
