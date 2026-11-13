<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$valorFecha = '';
$fechaAlta = null;
$errores = [];
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entrada = $_POST['fechaAlta'] ?? '';
    if (!is_string($entrada)) {
        $errores['fechaAlta'] = 'La fecha debe ser texto.';
    } else {
        $valorFecha = trim($entrada);
        if ($valorFecha !== '') {
            try {
                $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $valorFecha);
            } catch (ValueError) {
                $fecha = false;
            }
            if ($fecha === false || $fecha->format('Y-m-d') !== $valorFecha) {
                $errores['fechaAlta'] = 'Fecha no válida.';
            } else {
                $fechaAlta = $fecha;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fecha de alta</title>
</head>
<body>
    <form method="post" action="fecha.php">
        <label for="fechaAlta">Fecha de alta (opcional)</label>
        <input id="fechaAlta" type="text" name="fechaAlta" placeholder="AAAA-MM-DD" value="<?= e($valorFecha) ?>">
        <?php if (isset($errores['fechaAlta'])): ?>
            <span><?= e($errores['fechaAlta']) ?></span>
        <?php endif; ?>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $errores === []): ?>
        <?php if ($fechaAlta === null): ?>
            <p>Sin fecha de alta (null).</p>
        <?php else: ?>
            <p>Fecha aceptada: <?= e($fechaAlta->format('Y-m-d')) ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
