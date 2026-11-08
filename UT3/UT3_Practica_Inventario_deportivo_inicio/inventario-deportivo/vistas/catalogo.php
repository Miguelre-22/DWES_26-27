<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Catálogo del inventario</title></head>
<body>
<h1>Catálogo del inventario</h1>
<p><a href="alta.php">Dar de alta un material</a></p>
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
        <label for="q">Nombre o fabricante</label>
        <input type="text" id="q" name="q" value="">
    </p>
    <p>
        <label for="categoria">Categoría</label>
        <select id="categoria" name="categoria">
            <option value="">Todas</option>
            <option value="colectivo">Colectivo</option>
            <option value="raqueta">Raqueta</option>
            <option value="fitness">Fitness</option>
        </select>
    </p>
    <p>
        <button type="submit">Buscar</button>
    </p>
</form>
<?php if ($errores === []): ?>
    <!-- COMPLETAR 3. Tabla de materiales o mensaje si no hay coincidencias. -->
    <?php if ($materiales !== []): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fabricante</th>
                    <th>Unidades</th>
                    <th>Categoría</th>
                    <th>Fecha de alta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materiales as $material): ?>
                    <?php $fecha = $material->fechaAlta(); ?>
                    <tr>
                        <td><?= e($material->nombre()) ?></td>
                        <td><?= e($material->fabricante()) ?></td>
                        <td><?= $material->unidades() ?></td>
                        <td><?= e($material->categoria()) ?></td>
                        <td><?= $fecha === null ? 'Sin fecha' : e($fecha->format('Y-m-d')) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay materiales que coincidan.</p>
    <?php endif; ?>
<?php endif; ?>
<p><a href="index.php">Limpiar filtros</a></p>
</body>
</html>
