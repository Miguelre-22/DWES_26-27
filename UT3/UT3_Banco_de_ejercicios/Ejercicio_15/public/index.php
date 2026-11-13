<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

$titulo = '';
$errores = [];
$datosArchivo = null;
$extension = null;
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entradaTitulo = $_POST['titulo'] ?? '';
    if (!is_string($entradaTitulo)) {
        $errores['titulo'] = 'El título debe ser texto.';
    } else {
        $titulo = trim($entradaTitulo);
    }

    $archivo = $_FILES['portada'] ?? null;
    if (estadoRecepcion($archivo, $errores) === 'recibido') {
        $datosArchivo = [
            'name' => is_string($archivo['name'] ?? null) ? $archivo['name'] : '',
            'type' => is_string($archivo['type'] ?? null) ? $archivo['type'] : '',
            'mime' => detectarMime($archivo['tmp_name']),
        ];
        $extension = extensionPortada($archivo, $errores);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formato por contenido</title>
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
            <label for="portada">Portada</label>
            <input id="portada" type="file" name="portada" accept="image/jpeg,image/png,image/webp">
            <?php if (isset($errores['portada'])): ?>
                <span><?= e($errores['portada']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($datosArchivo !== null): ?>
        <ul>
            <li>name (cliente): <?= e($datosArchivo['name']) ?></li>
            <li>type (cliente): <?= e($datosArchivo['type']) ?></li>
            <li>MIME detectado por finfo: <?= e($datosArchivo['mime'] === false ? 'no detectado' : $datosArchivo['mime']) ?></li>
        </ul>
        <?php if ($extension !== null): ?>
            <p>Formato aceptado. Extensión de destino: <?= e($extension) ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
