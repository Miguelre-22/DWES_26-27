<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function describir(string|false|null $resultado): string
{
    if (is_string($resultado)) {
        return 'Correo válido: ' . $resultado;
    }
    if ($resultado === false) {
        return 'Correo no válido.';
    }
    return 'El campo email no ha llegado.';
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$mensaje = describir($email);

$_POST['email'] = 'cambiado@example.org';
$mensajeTrasModificar = describir(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>filter_input</title>
</head>
<body>
    <p><?= e($mensaje) ?></p>
    <p>Tras modificar $_POST: <?= e($mensajeTrasModificar) ?></p>
    <p><a href="contacto.php">Volver</a></p>
</body>
</html>
