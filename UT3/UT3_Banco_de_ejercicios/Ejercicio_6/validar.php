<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$titulo = '';
$autor = '';
$errores = [];
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entradaTitulo = $_POST['titulo'] ?? '';
    if (!is_string($entradaTitulo)) {
        $errores['titulo'] = 'El título debe ser texto.';
    } else {
        $titulo = trim($entradaTitulo);
    }

    $entradaAutor = $_POST['autor'] ?? '';
    if (!is_string($entradaAutor)) {
        $errores['autor'] = 'El autor debe ser texto.';
    } else {
        $autor = trim($entradaAutor);
    }

    if (!isset($errores['titulo'])) {
        if ($titulo === '') {
            $errores['titulo'] = 'El título es obligatorio.';
        } elseif (mb_strlen($titulo, 'UTF-8') > 120) {
            $errores['titulo'] = 'El título admite como máximo 120 caracteres.';
        }
    }

    if (!isset($errores['autor']) && $autor === '') {
        $errores['autor'] = 'El autor es obligatorio.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar título y autor</title>
</head>
<body>
    <form method="post" action="validar.php">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" type="text" name="titulo" value="<?= e($titulo) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <span><?= e($errores['titulo']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="autor">Autor</label>
            <input id="autor" type="text" name="autor" value="<?= e($autor) ?>">
            <?php if (isset($errores['autor'])): ?>
                <span><?= e($errores['autor']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $errores === []): ?>
        <p>Aceptado: «<?= e($titulo) ?>» de «<?= e($autor) ?>»</p>
    <?php endif; ?>
</body>
</html>
