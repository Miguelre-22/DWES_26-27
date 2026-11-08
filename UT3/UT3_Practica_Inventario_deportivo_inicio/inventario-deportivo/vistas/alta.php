<?php
use function App\Soporte\e;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Alta de un material</title></head>
<body>
<h1>Alta de un material</h1>
<?php if ($creado === null): ?>
    <!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
<?php if ($errores !== []): ?>
    <ul role="alert">
        <?php foreach ($errores as $campo => $mensaje): ?>
            <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
    <!-- COMPLETAR 4. Formulario POST multipart con controles HTML estáticos. -->
    <form method="post" action="alta.php" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre">
        </p>
        <p>
            <label for="fabricante">Fabricante</label>
            <input type="text" id="fabricante" name="fabricante">
        </p>
        <p>
            <label for="unidades">Unidades</label>
            <input type="text" id="unidades" name="unidades">
        </p>
        <p>
            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria">
                <option value="">Elige una categoría</option>
                <option value="colectivo">Colectivo</option>
                <option value="raqueta">Raqueta</option>
                <option value="fitness">Fitness</option>
            </select>
        </p>
        <p>
            <label for="fechaAlta">Fecha de alta (YYYY-MM-DD)</label>
            <input type="text" id="fechaAlta" name="fechaAlta">
        </p>
        <p>
            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
        </p>
        <p>
            <button type="submit">Guardar material</button>
        </p>
    </form>
<?php else: ?>
    <!-- Confirmación proporcionada. Solo aparece cuando asignas $creado. -->
    <h2>Material registrado</h2>
    <dl>
        <dt>Nombre</dt><dd><?= e($creado->nombre()) ?></dd>
        <dt>Fabricante</dt><dd><?= e($creado->fabricante()) ?></dd>
        <dt>Unidades</dt><dd><?= $creado->unidades() ?></dd>
        <dt>Categoría</dt><dd><?= e($creado->categoria()) ?></dd>
        <dt>Fecha de alta</dt><dd><?= e($creado->fechaAlta()?->format('Y-m-d') ?? 'Sin fecha') ?></dd>
    </dl>
    <p>La colección de este envío contiene <?= count($inventario->todos()) ?> materiales.</p>
    <?php if ($creado->imagen() !== null): ?>
        <img src="imagen.php?nombre=<?= e($creado->imagen()) ?>"
             alt="Imagen del material creado" width="180">
    <?php else: ?>
        <p>Sin imagen</p>
    <?php endif; ?>
    <p><a href="alta.php">Nueva alta</a></p>
<?php endif; ?>
<p><a href="index.php">Volver al catálogo</a></p>
</body>
</html>
