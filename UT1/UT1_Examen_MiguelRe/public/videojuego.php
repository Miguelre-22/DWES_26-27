<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$id = (int) ($_GET['id'] ?? 0);

$videojuego = $videojuegos;

$videojuegoPorId = buscarPorId($videojuego, $id);

if ($videojuegoPorId === null) {
    // Completa el tratamiento del caso en el que el videojuego no existe.
    ?>
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Videojuego no encontrado</title>
    </head>
    <body>
        <p>El videojuego no se ha encontrado</p>
    </body>
    </html>
    <?php
    exit;
}

// Prepara las fechas y los valores que necesita la ficha.
$fechaLanzamiento = new DateTimeImmutable($videojuegoPorId['fechaLanzamiento']);// De dónde saco la fecha??
$hoy = new DateTimeImmutable();
$diasTranscurridos = $fechaLanzamiento->diff($hoy); //0? Habrá que calcular algo, no?
$finNovedad = null;
$estado = '';

// COMPLETAR los cálculos anteriores utilizando los datos del videojuego.
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ficha del videojuego</title>
</head>
<body>
    <h1><?= htmlspecialchars($videojuegoPorId['titulo'] ?? '') ?></h1>

    <dl>
        <dt>Estudio</dt>
        <dd><?= htmlspecialchars($videojuegoPorId['estudio'] ?? '') ?></dd>

        <dt>Género</dt>
        <dd><?= htmlspecialchars($videojuegoPorId['genero'] ?? '') ?></dd>

        <dt>Plataforma</dt>
        <dd><?= htmlspecialchars($videojuegoPorId['plataforma'] ?? '') ?></dd>

        <dt>Precio</dt>
        <dd>
            <?php if ($videojuegoPorId !== null): ?>
                <?= number_format($videojuegoPorId['precio'], 2, ',', '.') ?> €
            <?php endif; ?>
        </dd>

        <dt>Puntuación</dt>
        <dd><?= $videojuegoPorId['puntuacion'] ?? '' ?></dd>

        <dt>Fecha de lanzamiento</dt>
        <dd><?= $videojuegoPorId['fechaLanzamiento']; ?></dd>

        <dt>Días desde el lanzamiento</dt>
        <dd></dd>

        <dt>Fin del periodo de novedad</dt>
        <dd><!-- COMPLETAR --></dd>

        <dt>Estado</dt>
        <dd><!-- COMPLETAR --></dd>
    </dl>

    <p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
