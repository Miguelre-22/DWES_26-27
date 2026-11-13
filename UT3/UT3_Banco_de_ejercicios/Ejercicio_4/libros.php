<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$q = '';
$error = null;

$entrada = $_GET['q'] ?? '';
if (!is_string($entrada)) {
    $error = 'Entrada no válida.';
} else {
    $q = trim($entrada);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros</title>
</head>
<body>
    <form method="get" action="libros.php">
        <label for="q">Buscar</label>
        <input id="q" type="search" name="q" value="<?= e($q) ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($error !== null): ?>
        <p><?= e($error) ?></p>
    <?php else: ?>
        <p>Búsqueda: <?= e($q) ?></p>
    <?php endif; ?>
</body>
</html>
