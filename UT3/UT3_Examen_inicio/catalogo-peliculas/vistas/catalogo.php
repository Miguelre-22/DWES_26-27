<?php

use function App\Soporte\e;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo de películas</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <main class="contenedor">
        <header class="cabecera">
            <h1>Catálogo de películas</h1>
            <p class="acciones"><a href="alta.php">Dar de alta una película</a></p>
        </header>

        <!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
        <?php if ($errores !== []): ?>
            <ul role="alert">
                <?php foreach ($errores as $campo => $mensaje): ?>
                    <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- COMPLETAR 1. Formulario GET con controles HTML estáticos. -->
        <form action="index.php" method="get">
            <label for="q">Título o director</label>
            <input type="text" id="q" name="q" value="">
            
            <label for="genero">Género</label>
            <select name="genero" id="genero">
                <option value="">Todos</option>
                <option value="ciencia">Ciencia ficción</option>
                <option value="fantasia">Fantasía</option>
                <option value="terror">Terror</option>
            </select>

            <button type="submit">Buscar</button>
        </form>

        <?php if ($errores === []): ?>
            <!-- Listado proporcionado. -->
            <?php if ($peliculas === []): ?>
                <p class="vacio">No hay películas que coincidan</p>
            <?php else: ?>
                <div class="tabla" role="region" aria-label="Películas del catálogo" tabindex="0">
                    <table>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Director</th>
                                <th>Duración</th>
                                <th>Género</th>
                                <th>Fecha de estreno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peliculas as $pelicula): ?>
                                <tr>
                                    <td><?= e($pelicula->titulo()) ?></td>
                                    <td><?= e($pelicula->director()) ?></td>
                                    <td><?= $pelicula->duracion() ?></td>
                                    <td><?= e($pelicula->genero()) ?></td>
                                    <td>
                                        <?php if ($pelicula->fechaEstreno() === null): ?>
                                            Sin fecha
                                        <?php else: ?>
                                            <?= e($pelicula->fechaEstreno()->format('Y-m-d')) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        <p class="acciones"><a href="index.php">Limpiar filtros</a></p>
    </main>
</body>

</html>
