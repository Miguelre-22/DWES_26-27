<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo de la biblioteca</title></head>
<body>
<h1>Catálogo de la biblioteca</h1>
<p><a href="alta.php">Dar de alta un libro</a></p>
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
    <label for="q">Título o autor</label>
    <input type="text" name="q" id="q" value="">
    <br><br>
    <label for="genero">Género</label>
    <select name="genero" id="genero">
        <option value="">Todos</option>
        <option value="ciencia">Ciencia</option>
        <option value="fantasia">Fantasía</option>
        <option value="terror">Terror</option>
    </select>
    <br><br>
    <button type="submit">Buscar</button>
</form>

<?php if ($errores === []): ?>
    <!-- COMPLETAR 3. Tabla de libros o mensaje si no hay coincidencias. -->
    <?php if ($libros !== []): ?>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Páginas</th>
                    <th>Género</th>
                    <th>Fecha de alta</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?= e($libro->titulo()) ?></td>
                    <td><?= e($libro->autor()) ?></td>
                    <td><?= $libro->paginas() ?></td>
                    <td><?= e($libro->genero()) ?></td>
                    <?php if($libro->fechaAlta() === null): ?>
                        <td>Sin fecha</td>
                    <?php else: ?>
                        <td><?= e($libro->fechaAlta()->format("Y-m-d")) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay libros que coincidan.</p>
    <?php endif; ?>

<?php endif; ?>
<p><a href="index.php">Limpiar filtros</a></p>
</body>
</html>
