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

    $archivo = $_FILES['portada'] ?? null;
    $estado = estadoRecepcion($archivo, $errores);
    if ($estado === 'recibido') {
        if (!tamanoValido($archivo['size'])) {
            $errores['portada'] = 'La portada debe ocupar entre 1 byte y 2 MiB.';
        } else {
            $mensaje = 'Tamaño correcto: ' . $archivo['size'] . ' bytes.';
        }
    } elseif ($estado !== 'error') {
        $mensaje = 'Se continúa sin nueva portada.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Límite de tamaño</title>
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
            <label for="portada">Portada (máximo 2 MiB)</label>
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
