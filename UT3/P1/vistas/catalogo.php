<?php require_once __DIR__ . '/funciones.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de la biblioteca</title>
</head>
<body>
    <h1>Catálogo de la biblioteca</h1>

    <form action="index.php" method="get">
        <p>
            <label for="q">Título o autor</label>
            <input type="text" id="q" name="q">
        </p>
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                <option value="ciencia">Ciencia</option>
                <option value="fantasia">Fantasía</option>
                <option value="terror">Terror</option>
            </select>
        </p>
        <p>
            <label for="tipo">Tipo de libro</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="papel">Papel</option>
                <option value="digital">Digital</option>
            </select>
        </p>
        <p>
            <label for="destacados">Solo destacados</label>
            <input type="checkbox" id="destacados" name="destacados" value="1">
        </p>
        <button type="submit">Buscar</button>
    </form>

    <p>
        <a href="alta.php">Dar de alta un libro</a> ·
        <a href="index.php">Ver catálogo inicial</a>
    </p>

    <?php require __DIR__ . '/tabla_catalogo.php'; ?>
</body>
</html>
