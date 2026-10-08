<?php
    // Catálogo de libros
    $libros = [
        [
            "titulo" => "Dune",
            "autor" => "Frank Herbert",
            "genero" => "Ciencia ficción"
        ],
        [
            "titulo" => "El nombre del viento",
            "autor" => "Patrick Rothfuss",
            "genero" => "Fantasía"
        ],
        [
            "titulo" => "1984",
            "autor" => "George Orwell",
            "genero" => "Ciencia ficción"
        ],
        [
            "titulo" => "Drácula",
            "autor" => "Bram Stoker",
            "genero" => "Terror"
        ],
        [
            "titulo" => "El Hobbit",
            "autor" => "J. R. R. Tolkien",
            "genero" => "Fantasía"
        ],
        [
            "titulo" => "It",
            "autor" => "Stephen King",
            "genero" => "Terror"
        ]
    ];

    // Función para filtrar por género
    function filtrarPorGenero($libros, $genero)
    {
        if ($genero === "") {
            return $libros;
        }

        $resultado = [];

        foreach ($libros as $libro) {
            if (strtolower($libro["genero"]) === strtolower($genero)) {
                $resultado[] = $libro;
            }
        }

        return $resultado;
    }

    // Obtener el género de la URL
    $genero = $_GET["genero"] ?? "";

    // Filtrar libros
    $librosFiltrados = filtrarPorGenero($libros, $genero);

    // Ordenar los títulos alfabéticamente
    usort($librosFiltrados, function ($a, $b) {
        return strcmp($a["titulo"], $b["titulo"]);
    });

    // Fecha de revisión: hoy + 30 días
    $fechaRevision = date("d/m/Y", strtotime("+30 days"));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de libros</title>
</head>
<body>

    <h1>Catálogo de libros</h1>

    <p>
        Resultados encontrados:
        <?php echo count($librosFiltrados); ?>
    </p>

    <p>
        Próxima revisión del catálogo:
        <?php echo $fechaRevision; ?>
    </p>

    <h2>Libros</h2>

    <?php if (count($librosFiltrados) > 0): ?>

        <ul>
            <?php foreach ($librosFiltrados as $libro): ?>
                <li>
                    <strong><?php echo $libro["titulo"]; ?></strong>
                    -
                    <?php echo $libro["autor"]; ?>
                    -
                    <?php echo $libro["genero"]; ?>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>

        <p>No se encontraron libros de ese género.</p>

    <?php endif; ?>

</body>
</html>