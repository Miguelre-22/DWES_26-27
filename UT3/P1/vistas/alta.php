<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="alta.php" method="post">
        <p>
            <label for="tipo">Tipo de libro</label>
            <select id="tipo" name="tipo">
                <option value="papel">Papel</option>
                <option value="digital">Digital</option>
            </select>
        </p>

        <p>
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" maxlength="120">
        </p>

        <p>
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" maxlength="100">
        </p>

        <p>
            <label for="paginas">Páginas</label>
            <input type="number" id="paginas" name="paginas" max="3000">
        </p>

        <p>
            <label for="genero">Género</label>

            <select id="genero" name="genero">
                <option value="ciencia">Ciencia</option>
                <option value="fantasia">Fatasía</option>
                <option value="terror">Terror</option>
            </select>
        </p>

        <p>
            <label for="unidades">Unidades</label>
            <input type="number" id="unidades" name="unidades" min="1" max="50">
        </p>

        <p>
            <label for="fechaAlta">Fecha de Alta</label>
            <input type="date" id="fechaAlta" name="fechaAlta">
        </p>

        <p>
            <label for="destacados">Solo destacados</label>
            <input type="checkbox" value="1" id="destacados" name="destacados">
        </p>

        <p>
            <textarea name="observaciones">Observaciones</textarea>
        </p>

        <p>
            <label for="correo">Correo</label>
            <input type="text" id="correo" name="correo" required>
        </p>

        <button type="submit">Buscar</button>
    </form>
</body>

</html>