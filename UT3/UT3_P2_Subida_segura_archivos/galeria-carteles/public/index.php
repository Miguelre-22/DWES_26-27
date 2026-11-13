<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/archivos.php';

$carteles = listarCarteles();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería de carteles</title>
</head>
<body>
    <h1>Galería de carteles</h1>
    <p><a href="subir.php">Subir cartel</a></p>

    <?php if ($carteles === null): ?>
        <p>No se ha podido leer la galería.</p>
    <?php elseif ($carteles === []): ?>
        <p>Todavía no hay carteles</p>
    <?php else: ?>
        <?php foreach ($carteles as $cartel): ?>
            <figure>
                <img src="<?= e('imagen.php?nombre=' . $cartel['nombre']) ?>" alt="Cartel <?= e($cartel['nombre']) ?>">
                <figcaption>
                    <?= e($cartel['nombre']) ?>
                    <a href="<?= e('subir.php?anterior=' . $cartel['nombre']) ?>">Sustituir</a>
                </figcaption>
            </figure>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>