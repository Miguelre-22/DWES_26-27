<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

$titulo = '';
$errores = [];
$portada = null;
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entradaTitulo = $_POST['titulo'] ?? '';
    if (!is_string($entradaTitulo)) {
        $errores['titulo'] = 'El título debe ser texto.';
    } else {
        $titulo = trim($entradaTitulo);
    }

    $archivo = $_FILES['portada'] ?? null;
    if (!estructuraArchivoValida($archivo)) {
        $errores['portada'] = 'La portada no tiene la estructura esperada.';
    } else {
        $portada = $archivo;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portada</title>
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

    <?php if ($portada !== null): ?>
        <p>Código de recepción: <?= $portada['error'] ?>. Tamaño: <?= $portada['size'] ?> bytes.</p>
    <?php endif; ?>
</body>
</html>
