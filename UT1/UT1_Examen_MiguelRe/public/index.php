<?php

declare(strict_types=1);


// Importar librerías
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';
// Poner la zona horaria
$zonaHoraria = new DateTimeZone('Europe/Madrid');
// 3.1. Leer parámetros
$genero = $_GET['genero'] ?? 'todos';
$plataforma = $_GET['plataforma'] ?? 'todas';
$q = $_GET['q'] ?? '';
$orden = $_GET['orden'] ?? 'titulo';
// 3.2. Normalizar y comprobar que los valores recibidos estén dentro de los esperados
$generoNormalizado = normalizarTexto($genero);
$plataformaNormalizado = normalizarTexto($plataforma);
$qNormalizado = normalizarTexto($q);
$ordenNormalizado = normalizarTexto($orden);

if ($generoNormalizado !== 'accion' && $generoNormalizado !== 'rol' && $generoNormalizado !== 'carreras' && $generoNormalizado !== 'estrategia' && $generoNormalizado !== 'aventura' && $generoNormalizado !== 'simulacion' && $generoNormalizado !== 'terror'){
    $generoNormalizado = 'todos';
}

if ($plataformaNormalizado !== 'xsx' && $plataformaNormalizado !== 'sw' && $plataformaNormalizado !== 'ps5' && $plataformaNormalizado !== 'pc'){
    $plataformaNormalizado = 'todas';
}
// 3.3. Filtros
$resultados = $videojuegos;
$busqueda = 0;

$resultados =  filtrarPorGenero($resultados, $generoNormalizado);
$resultados =  filtrarPorPlataforma($resultados, $plataformaNormalizado);
//$resultados = filtrarPorGenero($resultados, $generoNormalizado) && filtrarPorPlataforma($resultados, $plataformaNormalizado);

// Aplica sobre $resultados los filtros, la búsqueda y la ordenación solicitados.

// 3.5. Ordenar salida
// Ordena las dos colecciones anteriores manteniendo la relación entre claves y valores.
$plataformasOrdenadas  = $plataformas;
$ventasOrdenadas = $ventasSemana;


$timestampConsulta = time();
$fechaConsulta = new DateTimeImmutable('today'); // COMPLETAR
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Catálogo de videojuegos</title>
</head>
<body>
    <h1>Catálogo de videojuegos</h1>

    <form method="get">
        <label>
            Género:
            <input type="text" name="genero" value="<?= htmlspecialchars($generoNormalizado) ?>">
        </label>

        <label>
            Plataforma:
            <select name="plataforma">
                <option value="todas">Todas</option>
                <?php foreach ($plataformas as $codigo => $nombre): ?>
                    <option value="<?= htmlspecialchars($codigo) ?>">
                        <?= htmlspecialchars($nombre) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Buscar:
            <input type="text" name="q" value="<?= $busqueda ?>">
        </label>

        <label>
            Orden:
            <select name="orden">
                <option value="titulo">Título</option>
                <option value="precio">Precio</option>
                <option value="puntuacion">Puntuación</option>
            </select>
        </label>

        <button type="submit">Aplicar</button>
    </form>

    <p>Resultados: <?= count($resultados) ?></p>

    <ul>
        <?php foreach ($resultados as $videojuego): ?>
            <li>
                <!-- Construye aquí el enlace a videojuego.php enviando su id. -->
                <!-- <p><a href="libros.php?id=$videojuego['id']'">Ir al libro</a></p> -->
                <?= htmlspecialchars($videojuego['titulo']) ?>
                · <?= number_format($videojuego['precio'], 2, ',', '.') ?> €
                · <?= $videojuego['puntuacion'] ?>/10
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Plataformas por código</h2>
    <ul>
        <?php foreach ($plataformasOrdenadas as $codigo => $nombre): ?>
            <li><?= htmlspecialchars((string) $codigo) ?>: <?= htmlspecialchars((string) $nombre) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Ventas de la semana</h2>
    <ul>
        <?php foreach ($ventasOrdenadas as $codigo => $ventas): ?>
            <li><?= htmlspecialchars((string) $codigo) ?>: <?= $ventas ?></li>
        <?php endforeach; ?>
    </ul>

    <p>Consulta generada: </p>
</body>
</html>