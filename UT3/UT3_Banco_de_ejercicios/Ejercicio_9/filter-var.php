<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$entrada = $_POST['email'] ?? null;

if ($entrada === null) {
    $mensaje = 'El campo email no ha llegado.';
} elseif (!is_string($entrada)) {
    $mensaje = 'El correo debe ser texto.';
} else {
    $email = filter_var(trim($entrada), FILTER_VALIDATE_EMAIL);
    $mensaje = $email === false ? 'Correo no válido.' : 'Correo válido: ' . $email;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>filter_var</title>
</head>
<body>
    <p><?= e($mensaje) ?></p>
    <p><a href="contacto.php">Volver</a></p>
</body>
</html>
