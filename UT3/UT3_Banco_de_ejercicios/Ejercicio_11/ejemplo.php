<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$datos = null;
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    foreach (['titulo', 'paginas'] as $campo) {
        $entrada = $_POST[$campo] ?? '';
        if (!is_string($entrada)) {
            $errores[$campo] = 'Debe ser texto.';
        } else {
            $valores[$campo] = trim($entrada);
        }
    }

    if (!isset($errores['titulo'])) {
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'El título es obligatorio.';
        } elseif (mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'Máximo 120 caracteres.';
        }
    }

    $paginas = false;
    if (!isset($errores['paginas'])) {
        $paginas = filter_var($valores['paginas'], FILTER_VALIDATE_INT);
        if ($paginas === false || $paginas < 1 || $paginas > 3000) {
            $errores['paginas'] = 'Entre 1 y 3000 páginas.';
        }
    }

    if ($errores === []) {
        $datos = ['titulo' => $valores['titulo'], 'paginas' => $paginas];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo libro</title>
</head>
<body>
    <?php if ($datos !== null): ?>
        <p>Libro guardado: «<?= e($datos['titulo']) ?>», <?= $datos['paginas'] ?> páginas.</p>
    <?php else: ?>
        <form method="post" action="ejemplo.php">
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
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>
</body>
</html>
