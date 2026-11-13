<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

$portadaActual = '7c1e5a3b9d2f4e60a8b7c6d5e4f3a2b1.png';

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$errorPortada = null;
$erroresGenerales = [];
$datos = null;
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $resultado = validarFicha($_POST);
    $valores = $resultado['valores'];
    $errores = $resultado['errores'];

    $erroresArchivo = [];
    $archivo = $_FILES['portada'] ?? null;
    $extension = null;
    if (estadoRecepcion($archivo, $erroresArchivo) === 'recibido') {
        $extension = extensionPortada($archivo, $erroresArchivo);
    }
    $errorPortada = $erroresArchivo['portada'] ?? null;

    if ($errores === [] && $errorPortada === null && $extension !== null) {
        $destino = prepararDestino($extension, $erroresGenerales);
        if ($destino !== null) {
            if (move_uploaded_file($archivo['tmp_name'], $destino['destino']) === true) {
                $portadaActual = $destino['nombre'];
            } else {
                $erroresGenerales[] = 'No se pudo guardar la portada.';
            }
        }
    }

    if ($errores === [] && $errorPortada === null && $erroresGenerales === []) {
        $datos = $resultado['datos'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro con portada</title>
</head>
<body>
    <?php if ($datos !== null): ?>
        <p>Libro guardado: «<?= e($datos['titulo']) ?>», <?= $datos['paginas'] ?> páginas.</p>
        <p>Portada: <?= $portadaActual === null ? 'sin portada' : e($portadaActual) ?></p>
    <?php else: ?>
        <?php foreach ($erroresGenerales as $error): ?>
            <p><?= e($error) ?></p>
        <?php endforeach; ?>
        <form method="post" action="formulario-portada.php" enctype="multipart/form-data">
            <p>
                <label for="titulo">Título</label>
                <input id="titulo" type="text" name="titulo" value="<?= e($valores['titulo']) ?>">
                <?php if (isset($errores['titulo'])): ?>
                    <span><?= e($errores['titulo']) ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label for="paginas">Páginas</label>
                <input id="paginas" type="number" name="paginas" value="<?= e($valores['paginas']) ?>">
                <?php if (isset($errores['paginas'])): ?>
                    <span><?= e($errores['paginas']) ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label for="portada">Portada (opcional, máximo 2 MiB)</label>
                <input id="portada" type="file" name="portada" accept="image/jpeg,image/png,image/webp">
                <?php if ($errorPortada !== null): ?>
                    <span><?= e($errorPortada) ?></span>
                <?php endif; ?>
            </p>
            <button type="submit">Guardar</button>
        </form>
        <p>Portada actual: <?= $portadaActual === null ? 'sin portada' : e($portadaActual) ?></p>
    <?php endif; ?>
</body>
</html>
