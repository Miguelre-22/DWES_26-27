<?php

use function App\Soporte\e;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de videojuegos</title>
</head>

<body>
    <h1>Catálogo de videojuegos</h1>
    <p><a href="alta.php">Dar de alta un videojuego</a></p>

    <!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
    <?php if ($errores !== []): ?>
        <ul role="alert">
            <?php foreach ($errores as $campo => $mensaje): ?>
                <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- COMPLETAR 1. Formulario GET con controles HTML estáticos. -->
    <form method="get" action="index.php">
        <p>
            <label for="q">Título o estudio</label>
            <input type="text" id="q" name="q" value="">
        </p>
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                <option value="aventura">Aventura</option>
                <option value="estrategia">Estrategia</option>
                <option value="rol">Rol</option>
            </select>
        </p>
        <p>
            <button type="submit">Buscar</button>
        </p>
    </form>
    <?php if ($errores === []): ?>
        <!-- Listado proporcionado. -->
        <?php if ($videojuegos === []): ?>
            <p>No hay videojuegos que coincidan</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Estudio</th>
                        <th>Horas de juego</th>
                        <th>Género</th>
                        <th>Fecha de lanzamiento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($videojuegos as $videojuego): ?>
                        <tr>
                            <td><?= e($videojuego->titulo()) ?></td>
                            <td><?= e($videojuego->estudio()) ?></td>
                            <td><?= $videojuego->horas() ?></td>
                            <td><?= e($videojuego->genero()) ?></td>
                            <td>
                                <?php if ($videojuego->fechaLanzamiento() === null): ?>
                                    Sin fecha
                                <?php else: ?>
                                    <?= e($videojuego->fechaLanzamiento()->format('Y-m-d')) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php endif; ?>

    <p><a href="index.php">Limpiar filtros</a></p>
</body>

</html>
