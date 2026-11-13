<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$titulo = trim(' <Dune> & "edición" ');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fragmento</title>
</head>
<body>
    <p><?= e($titulo) ?></p>
    <input name="titulo" value="<?= e($titulo) ?>">
</body>
</html>
