<?php
    // 1. Incluye los archivos mediante require_once.
    declare(strict_types=1);
    require_once __DIR__ . '/../src/datos.php';
    require_once __DIR__ . '/../src/funciones.php';
    
    // 2. Muestra el catálogo completo.
    echo 'Mostrar catálogo completo:' . '<br>' . '<br>';

    foreach ($libros as $libro) {
        $fechaAlta = new DateTimeImmutable($libro['fechaAlta']);

        echo 'Título: ' . htmlspecialchars($libro['titulo']) . '<br>';
        echo 'Autor: ' . htmlspecialchars($libro['autor']) . '<br>';
        echo 'Género: ' . htmlspecialchars($libro['genero']) . '<br>';
        echo 'Número de páginas: ' . $libro['paginas'] . '<br>' . 'Disponibilidad: ';
        echo $libro['disponible'] ? 'Disponible' : 'No disponible';
        echo '<br>';
        echo 'Fecha de alta: ' . htmlspecialchars($libro['fechaAlta']) . '<br>';
        $hoy = new DateTimeImmutable();
        $diferencia = $fechaAlta->diff($hoy);
        $diasPasados = $diferencia->days;
        echo 'Días desde el alta: ' . $diasPasados . '<br>';
        echo '<hr>';
    }
        
    // 3. Permite filtrar con ?genero= y ?disponible=1.
    $genero = $_GET['genero'] ?? '';
    $disponible = $_GET['disponible'] ?? '';

    $mostrarLibros = $libros;

    if ($genero !== '') {
        $mostrarLibros = filtrarPorGenero($mostrarLibros, $genero);
    }

    if ($disponible === '1') {
        $mostrarLibros = filtrarDisponibles($mostrarLibros);
    }

    echo '<br>' . '<br>' . 'Mostrar catálogo con filtros:' . '<br>' . '<br>' . '<br>';
    
    foreach ($mostrarLibros as $libro) {
        $fechaAlta = new DateTimeImmutable($libro['fechaAlta']);

        echo 'Título: ' . htmlspecialchars($libro['titulo']) . '<br>';
        echo 'Autor: ' . htmlspecialchars($libro['autor']) . '<br>';
        echo 'Género: ' . htmlspecialchars($libro['genero']) . '<br>';
        echo 'Número de páginas: ' . $libro['paginas'] . '<br>' . 'Disponibilidad: ';
        echo $libro['disponible'] ? 'Disponible' : 'No disponible';
        echo '<br>';
        echo 'Fecha de alta: ' . htmlspecialchars($libro['fechaAlta']) . '<br>';
        $hoy = new DateTimeImmutable();
        $diferencia = $fechaAlta->diff($hoy);
        $diasPasados = $diferencia->days;
        echo 'Días desde el alta: ' . $diasPasados . '<br>';
        echo '<hr>';
    }

    // 4. Muestra número de resultados y media de páginas de los resultados.
    echo '<br>' . '<br>' . 'Muestra número de resultados y media de páginas de los resultados:' . '<br>' . '<br>' . '<br>';

    $numResultados = count($mostrarLibros); 
    $mediaPaginas = calcularMediaPaginas($mostrarLibros);

    echo 'Número de resultados: ' . $numResultados . '<br>'; 
    echo 'Media de páginas: ' . $mediaPaginas . '<br>'; 
    echo '<hr>';

    // 5. Muestra el libro con más páginas.
    echo '<br>' . '<br>' . 'Muestra el libro con más páginas:' . '<br>' . '<br>' . '<br>';

    $libroMasLargo = obtenerLibroMasLargo($mostrarLibros); 
    
    if ($libroMasLargo !== null) { 
        echo 'Libro con más páginas: ' . htmlspecialchars($libroMasLargo['titulo']) . '<br>'; 
        echo 'Número de páginas: ' . $libroMasLargo['paginas'] . '<br>';
    }
    echo '<hr>';

    // Calcula una fecha de revisión del catálogo 30 días después del momento actual.
    $ahora = new DateTimeImmutable();
    $fechaRevision = $ahora->modify('+30 days');
    echo '<br>' . 'Fecha de revisión del catálogo: ' . $fechaRevision->format('Y-m-d H:i:s') . '<br>';
?>