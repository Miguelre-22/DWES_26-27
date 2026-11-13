<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$valorPaginas = '';
$paginas = null;
$errores = [];
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entrada = $_POST['paginas'] ?? '';
    if (!is_string($entrada)) {
        $errores['paginas'] = 'Las páginas deben ser texto.';
    } else {
        $valorPaginas = $entrada;
        $numero = filter_var($entrada, FILTER_VALIDATE_INT);
        if ($numero === false) {
            $errores['paginas'] = 'Escribe un número entero.';
        } elseif ($numero < 1 || $numero > 3000) {
            $errores['paginas'] = 'Entre 1 y 3000 páginas.';
        }
    }

    if ($errores === []) {
        $paginas = $numero;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Páginas</title>
</head>
<body>
    <form method="post" action="paginas.php">
        <label for="paginas">Páginas</label>
        <input id="paginas" type="text" name="paginas" value="<?= e($valorPaginas) ?>">
        <?php if (isset($errores['paginas'])): ?>
            <span><?= e($errores['paginas']) ?></span>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($paginas !== null): ?>
        <p>Número aceptado: <?= $paginas ?></p>
    <?php endif; ?>
</body>
</html>
