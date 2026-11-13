<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$generos = ['ciencia' => 'Ciencia ficción', 'fantasia' => 'Fantasía', 'terror' => 'Terror'];

$genero = '';
$destacado = false;
$observaciones = '';
$errores = [];
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entradaGenero = $_POST['genero'] ?? '';
    if (!is_string($entradaGenero) || !in_array($entradaGenero, array_keys($generos), true)) {
        $errores['genero'] = 'Elige un género válido.';
    } else {
        $genero = $entradaGenero;
    }

    if (!array_key_exists('destacado', $_POST)) {
        $destacado = false;
    } elseif ($_POST['destacado'] === '1') {
        $destacado = true;
    } else {
        $errores['destacado'] = 'Valor de destacado no válido.';
    }

    $entradaObservaciones = $_POST['observaciones'] ?? '';
    if (!is_string($entradaObservaciones)) {
        $errores['observaciones'] = 'Las observaciones deben ser texto.';
    } else {
        $observaciones = $entradaObservaciones;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Género, destacado y observaciones</title>
</head>
<body>
    <form method="post" action="formulario.php">
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Elige un género</option>
                <?php foreach ($generos as $valor => $texto): ?>
                    <option value="<?= e($valor) ?>"<?= $genero === $valor ? ' selected' : '' ?>><?= e($texto) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['genero'])): ?>
                <span><?= e($errores['genero']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <input id="destacado" type="checkbox" name="destacado" value="1"<?= $destacado ? ' checked' : '' ?>>
            <label for="destacado">Destacado</label>
            <?php if (isset($errores['destacado'])): ?>
                <span><?= e($errores['destacado']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="observaciones">Observaciones</label>
            <textarea id="observaciones" name="observaciones"><?= e($observaciones) ?></textarea>
            <?php if (isset($errores['observaciones'])): ?>
                <span><?= e($errores['observaciones']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $errores === []): ?>
        <p>Datos aceptados.</p>
    <?php endif; ?>
</body>
</html>
