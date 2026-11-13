<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

$idFicha = 1;
$fichas = leerFichas();
$portadaActual = $fichas[$idFicha]['portada'];

$errores = [];
$erroresGenerales = [];
$mensaje = '';
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $simularFallo = ($_POST['simularFallo'] ?? '') === '1';
    $archivo = $_FILES['portada'] ?? null;
    $estado = estadoRecepcion($archivo, $errores);
    $extension = null;

    if ($estado === 'recibido') {
        $extension = extensionPortada($archivo, $errores);
    } elseif ($estado !== 'error') {
        $mensaje = 'No se ha recibido una nueva portada. Se conserva la actual.';
    }

    if ($errores === [] && $extension !== null) {
        $destino = prepararDestino($extension, $erroresGenerales);
        if ($destino !== null) {
            if (move_uploaded_file($archivo['tmp_name'], $destino['destino']) !== true) {
                $erroresGenerales[] = 'No se pudo guardar la portada.';
            } else {
                $portadaAnterior = $portadaActual;
                $portadaActual = $destino['nombre'];
                try {
                    if ($simularFallo) {
                        throw new RuntimeException('Fallo simulado antes de confirmar.');
                    }
                    $fichas[$idFicha]['portada'] = $portadaActual;
                    guardarFichas($fichas);
                    $mensaje = 'Portada sustituida.';
                    if ($portadaAnterior !== null && !portadaEnUso($fichas, $portadaAnterior)) {
                        borrarPortada($portadaAnterior);
                    }
                } catch (RuntimeException | JsonException $excepcion) {
                    error_log($excepcion->getMessage());
                    $portadaActual = $portadaAnterior;
                    $fichas[$idFicha]['portada'] = $portadaAnterior;
                    borrarPortada($destino['nombre']);
                    $erroresGenerales[] = 'No se pudo completar el cambio de portada. Se conserva la anterior.';
                }
            }
        }
    }
}

$archivosEnDirectorio = array_map('basename', glob(DIRECTORIO_PORTADAS . '/*') ?: []);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sustituir portada</title>
</head>
<body>
    <h1><?= e($fichas[$idFicha]['titulo']) ?></h1>

    <?php if ($portadaActual !== null): ?>
        <img src="/portada.php?nombre=<?= e(rawurlencode($portadaActual)) ?>" alt="Portada actual" width="100">
    <?php endif; ?>
    <p>$portadaActual: <?= $portadaActual === null ? 'null' : e($portadaActual) ?></p>

    <?php if ($mensaje !== ''): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>
    <?php foreach ($erroresGenerales as $error): ?>
        <p><?= e($error) ?></p>
    <?php endforeach; ?>

    <form method="post" action="index.php" enctype="multipart/form-data">
        <p>
            <label for="portada">Nueva portada</label>
            <input id="portada" type="file" name="portada" accept="image/jpeg,image/png,image/webp">
            <?php if (isset($errores['portada'])): ?>
                <span><?= e($errores['portada']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <input id="simularFallo" type="checkbox" name="simularFallo" value="1">
            <label for="simularFallo">Provocar fallo antes de confirmar</label>
        </p>
        <button type="submit">Sustituir</button>
    </form>

    <h2>storage/portadas</h2>
    <ul>
        <?php foreach ($archivosEnDirectorio as $archivo): ?>
            <li><?= e($archivo) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
