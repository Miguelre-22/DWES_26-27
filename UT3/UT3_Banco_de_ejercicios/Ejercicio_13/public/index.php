<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

$titulo = '';
$errores = [];
$mensaje = '';
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entradaTitulo = $_POST['titulo'] ?? '';
    if (!is_string($entradaTitulo)) {
        $errores['titulo'] = 'El título debe ser texto.';
    } else {
        $titulo = trim($entradaTitulo);
    }

    $estado = estadoRecepcion($_FILES['portada'] ?? null, $errores);
    $mensaje = match ($estado) {
        'ausente' => 'No se ha enviado el campo portada. Se continúa sin nueva portada.',
        'sin_archivo' => 'No se ha seleccionado archivo. Se continúa sin nueva portada.',
        'recibido' => 'Portada recibida. Se pasa a comprobar tamaño y formato.',
        'error' => '',
    };
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portada opcional</title>
</head>
<body>
    <form method="post" action="index.php" enctype="multipart/form-data">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" type="text" name="titulo" value="<?= e($titulo) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <span><?= e($errores['titulo']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="portada">Portada (opcional)</label>
            <input id="portada" type="file" name="portada" accept="image/jpeg,image/png,image/webp">
            <?php if (isset($errores['portada'])): ?>
                <span><?= e($errores['portada']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($mensaje !== ''): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>
</body>
</html>
