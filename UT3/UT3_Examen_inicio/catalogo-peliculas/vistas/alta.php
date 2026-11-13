<?php

use function App\Soporte\e;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alta de una película</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <main class="contenedor">
        <header class="cabecera">
            <h1>Alta de una película</h1>
        </header>

        <?php if ($creado === null): ?>
            <!-- Bloque de errores proporcionado. Cada entrada identifica el campo y su mensaje. -->
            <?php if ($errores !== []): ?>
                <ul role="alert">
                    <?php foreach ($errores as $campo => $mensaje): ?>
                        <li><?= e($campo) ?>: <?= e($mensaje) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- COMPLETAR 2. Formulario POST multipart con controles HTML estáticos. -->
            <form action="alta.php" method="post" enctype="multipart/form-data">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo">

                <label for="director">Director</label>
                <input type="text" id="director" name="director">

                <label for="duracion">Duración</label>
                <input type="text" id="duracion" name="duracion">

                <label for="genero">Género</label>
                <select name="genero" id="genero">
                    <option value="">Elige un género</option>
                    <option value="ciencia">Ciencia ficción</option>
                    <option value="fantasia">Fantasía</option>
                    <option value="terror">Terror</option>
                </select>

                <label for="fechaEstreno">Fecha de estreno (YYYY-MM-DD)</label>
                <input type="text" id="fechaEstreno" name="fechaEstreno">

                <label for="cartel">Cartelera</label> 
                <input type="file" id="cartel" name="cartel" accept="image/jpeg,image/png,image/webp">

                <button type="submit">Guardar película</button>
            </form>

        <?php else: ?>
            <!-- Confirmación proporcionada. Solo aparece cuando asignas $creado. -->
            <section class="ficha" aria-labelledby="titulo-ficha">
                <h2 id="titulo-ficha">Película creada</h2>

                <dl>
                    <dt>Título</dt>
                    <dd><?= e($creado->titulo()) ?></dd>

                    <dt>Director</dt>
                    <dd><?= e($creado->director()) ?></dd>

                    <dt>Duración</dt>
                    <dd><?= $creado->duracion() ?></dd>

                    <dt>Género</dt>
                    <dd><?= e($creado->genero()) ?></dd>

                    <dt>Fecha de estreno</dt>
                    <dd><?= e($creado->fechaEstreno()?->format('Y-m-d') ?? 'Sin fecha') ?></dd>
                </dl>

                <p>La colección de este envío contiene <?= count($catalogo->todos()) ?> películas.</p>

                <?php if ($creado->cartel() !== null): ?>
                    <img src="cartel.php?nombre=<?= e($creado->cartel()) ?>"
                         alt="Cartel de la película creada" width="180">
                <?php else: ?>
                    <p>Sin cartel</p>
                <?php endif; ?>

                <p class="acciones"><a href="alta.php">Nueva alta</a></p>
            </section>
        <?php endif; ?>

        <p class="acciones"><a href="index.php">Volver al catálogo</a></p>
    </main>
</body>

</html>
