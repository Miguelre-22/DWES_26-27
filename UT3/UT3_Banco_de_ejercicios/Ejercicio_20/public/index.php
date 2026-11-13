<?php

declare(strict_types=1);

require __DIR__ . '/../config/funciones.php';

$aceptadas = [];
$erroresArchivos = [];
$erroresGenerales = [];
$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $simularFallo = ($_POST['simularFallo'] ?? '') === '1';
    $archivos = $_FILES['portadas'] ?? null;

    if (!estructuraMultipleValida($archivos)) {
        $erroresGenerales[] = 'Los archivos no tienen la estructura esperada.';
    } else {
        $recibidos = [];
        foreach (array_keys($archivos['name']) as $i) {
            if ($archivos['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                $recibidos[$i] = [
                    'name' => $archivos['name'][$i],
                    'type' => $archivos['type'][$i],
                    'tmp_name' => $archivos['tmp_name'][$i],
                    'error' => $archivos['error'][$i],
                    'size' => $archivos['size'][$i],
                ];
            }
        }

        if ($recibidos === []) {
            $erroresGenerales[] = 'No se ha seleccionado ningún archivo.';
        } elseif (count($recibidos) > MAXIMO_PORTADAS) {
            $erroresGenerales[] = 'Puedes enviar como máximo ' . MAXIMO_PORTADAS . ' imágenes.';
        } else {
            $extensiones = [];
            foreach ($recibidos as $i => $archivo) {
                $errores = [];
                if (estadoRecepcion($archivo, $errores) === 'recibido') {
                    $extension = extensionPortada($archivo, $errores);
                    if ($extension !== null) {
                        $extensiones[$i] = $extension;
                    }
                }
                if (isset($errores['portada'])) {
                    $erroresArchivos[$i] = $errores['portada'];
                }
            }

            if ($erroresArchivos === []) {
                $movidos = [];
                $numero = 0;
                foreach ($extensiones as $i => $extension) {
                    $destino = prepararDestino($extension, $erroresGenerales);
                    if ($destino === null) {
                        break;
                    }
                    $numero++;
                    $movido = !($simularFallo && $numero === 2)
                        && move_uploaded_file($recibidos[$i]['tmp_name'], $destino['destino']);
                    if (!$movido) {
                        $erroresGenerales[] = 'No se pudo guardar la imagen ' . ($i + 1) . '.';
                        break;
                    }
                    $movidos[] = $destino['nombre'];
                }

                if ($erroresGenerales === []) {
                    $aceptadas = $movidos;
                } else {
                    foreach ($movidos as $nombre) {
                        borrarPortada($nombre);
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Varias portadas</title>
</head>
<body>
    <form method="post" action="index.php" enctype="multipart/form-data">
        <p>
            <label for="portadas">Portadas (hasta 3, máximo 2 MiB cada una)</label>
            <input id="portadas" type="file" name="portadas[]" multiple accept="image/jpeg,image/png,image/webp">
        </p>
        <p>
            <input id="simularFallo" type="checkbox" name="simularFallo" value="1">
            <label for="simularFallo">Provocar fallo en el segundo movimiento</label>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php foreach ($erroresGenerales as $error): ?>
        <p><?= e($error) ?></p>
    <?php endforeach; ?>

    <?php foreach ($erroresArchivos as $i => $error): ?>
        <p>Archivo <?= $i + 1 ?>: <?= e($error) ?></p>
    <?php endforeach; ?>

    <?php if ($aceptadas !== []): ?>
        <p>Imágenes aceptadas:</p>
        <ul>
            <?php foreach ($aceptadas as $nombre): ?>
                <li><?= e($nombre) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
