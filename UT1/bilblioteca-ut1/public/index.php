<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../src/datos.php';
    require_once __DIR__ . '/../src/funciones.php';

    // 1. Lista todos los libros.
    echo 'Mostrar catálogo completo:' . '<br>' . '<br>';

    foreach ($catalogo as $libro) {
        $fechaAlta = new DateTimeImmutable($libro['fechaAlta']);

        echo 'Id: ' . $libro['id'] . '<br>';
        echo 'Título: ' . htmlspecialchars($libro['titulo']) . '<br>';
        echo 'Autor: ' . htmlspecialchars($libro['autor']) . '<br>';
        echo 'Género: ' . htmlspecialchars($libro['genero']) . '<br>';
        echo 'Número de páginas: ' . $libro['paginas'] . '<br>' . 'Disponibilidad: ';
        echo $libro['disponible'] ? 'Disponible' : 'No disponible';
        echo '<br>';
        echo 'Fecha de alta: ' . htmlspecialchars($libro['fechaAlta']) . '<br>';
        echo '<hr>';
    }

    // 2. Permite filtrar por genero mediante GET.
    echo '<br>' . '<br>' . 'Mostrar catálogo filtrado por genero:' . '<br>' . '<br>';

    $genero = $_GET['genero'] ?? '';

    $libros = obtenerporGenero($catalogo, $genero);

    
    foreach($libros as $libro){
        echo 'Id: ' . $libro['id'] . '<br>';
        echo 'Título: ' . htmlspecialchars($libro['titulo']) . '<br>';
        echo 'Autor: ' . htmlspecialchars($libro['autor']) . '<br>';
        echo 'Género: ' . htmlspecialchars($libro['genero']) . '<br>';
        echo 'Número de páginas: ' . $libro['paginas'] . '<br>' . 'Disponibilidad: ';
        echo $libro['disponible'] ? 'Disponible' : 'No disponible';
        echo '<br>';
        echo 'Fecha de alta: ' . htmlspecialchars($libro['fechaAlta']) . '<br>';
        echo '<hr>';
    }
    

    // 3. Permite filtrar por disponibilidad mediante GET
    $disponible = $_GET['disponible'] ?? '';

    echo '<br>' . '<br>' . 'Mostrar catálogo filtrado por disponibilidad:' . '<br>' . '<br>';

    $libros = obtenerPorDisponibilidad($catalogo, $disponible);
    
    foreach($libros as $libro){
        echo 'Id: ' . $libro['id'] . '<br>';
        echo 'Título: ' . htmlspecialchars($libro['titulo']) . '<br>';
        echo 'Autor: ' . htmlspecialchars($libro['autor']) . '<br>';
        echo 'Género: ' . htmlspecialchars($libro['genero']) . '<br>';
        echo 'Número de páginas: ' . $libro['paginas'] . '<br>' . 'Disponibilidad: ';
        echo $libro['disponible'] ? 'Disponible' : 'No disponible';
        echo '<br>';
        echo 'Fecha de alta: ' . htmlspecialchars($libro['fechaAlta']) . '<br>';
        echo '<hr>';
    }

    // 4. Permite buscar texto en titulo o autor mediante ?q=.
    $titulo = $_GET['q'] ?? '';
    $autor = $_GET['q'] ?? '';

    echo '<br>' . '<br>' . 'Muestra el número de resultados:' . '<br>' . '<br>' . '<br>';

    $numResultados = count($catalogo); 
    echo 'Número de resultados: ' . $numResultados . '<br>';

?>