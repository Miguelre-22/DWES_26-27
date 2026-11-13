<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$titulo = '';
$errores = [];
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    if (!is_string($entrada)) {
        $errores['titulo'] = 'El título debe ser texto.';
        $titulo = '';
    } else {
        $titulo = trim($entrada);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibir</title>
</head>
<body>
    <form method="post" action="recibir.php">
        <label for="titulo">Título</label>
        <input id="titulo" type="text" name="titulo" value="<?= e($titulo) ?>">
        <?php if (isset($errores['titulo'])): ?>
            <span><?= e($errores['titulo']) ?></span>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
