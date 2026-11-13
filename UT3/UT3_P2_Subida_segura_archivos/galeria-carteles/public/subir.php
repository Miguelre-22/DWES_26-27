<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/archivos.php';

$esSustitucion = array_key_exists('anterior', $_GET);
$anterior = null;

if ($esSustitucion) {
    $anterior = cartelValido($_GET['anterior']);
    if ($anterior === null) {
        http_response_code(404);
        echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>No encontrado</title></head>'
            . '<body><p>Cartel no encontrado.</p><p><a href="index.php">Volver a la galería</a></p></body></html>';
        exit;
    }
}

$action = $esSustitucion ? 'subir.php?anterior=' . $anterior['nombre'] : 'subir.php';
$errores = [];
$aviso = null;
$exito = null;
$guardado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (postExcesivo()) {
        $errores[] = 'El envío supera el tamaño máximo que admite el servidor.';
    } else {
        $resultado = validarSubida($_FILES['imagen'] ?? null);

        if ($resultado['estado'] === 'sin_archivo') {
            if ($esSustitucion) {
                $aviso = 'No se ha cambiado el cartel';
            } else {
                $errores[] = 'Selecciona una imagen.';
            }
        } elseif ($resultado['estado'] === 'error') {
            $errores[] = $resultado['mensaje'];
        } else {
            $guardar = guardarSubida($resultado['tmp'], $resultado['ext'], $anterior['nombre'] ?? null);

            if (!$guardar['ok']) {
                $errores[] = $guardar['mensaje'];
            } elseif (!$esSustitucion) {
                $exito = 'Cartel guardado.';
                $guardado = $guardar['nombre'];
            } elseif (retirarArchivo($anterior['ruta'])) {
                $exito = 'Cartel sustituido.';
                $guardado = $guardar['nombre'];
            } elseif (retirarArchivo(rutaCartel($guardar['nombre']))) {
                $errores[] = 'No se ha podido retirar el cartel anterior. La sustitución no se ha completado.';
            } else {
                error_log('No se ha podido eliminar el archivo nuevo ' . $guardar['nombre']);
                $errores[] = 'No se ha podido completar la sustitución.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir cartel</title>
</head>
<body>
    <h1><?= $esSustitucion ? 'Sustituir cartel' : 'Subir cartel' ?></h1>

    <?php if ($exito !== null): ?>
        <p><?= e($exito) ?></p>
        <img src="<?= e('imagen.php?nombre=' . $guardado) ?>" alt="Cartel <?= e($guardado) ?>">
    <?php else: ?>
        <?php if ($esSustitucion): ?>
            <img src="<?= e('imagen.php?nombre=' . $anterior['nombre']) ?>" alt="Cartel actual <?= e($anterior['nombre']) ?>">
        <?php endif; ?>

        <?php if ($aviso !== null): ?>
            <p><?= e($aviso) ?></p>
        <?php endif; ?>

        <form action="<?= e($action) ?>" method="post" enctype="multipart/form-data">
            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
            <?php foreach ($errores as $error): ?>
                <p><?= e($error) ?></p>
            <?php endforeach; ?>
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <p><a href="index.php">Volver a la galería</a></p>
</body>
</html>