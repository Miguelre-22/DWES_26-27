<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../src/datos.php';
    require_once __DIR__ . '/../src/funciones.php';

    // 1. Número total de libros.
    $numResultados = count($catalogo); 
    echo 'Número total de libros: ' . $numResultados . '<br>';

    // 2. Número de disponibles y no disponibles.
    $disponibles = 0;
    foreach($catalogo as $libro){
        if($libro['disponible'] === true){
            $disponibles += 1;
        }
    }
    echo 'Número de libros disponibles: ' . $disponibles;
    echo '<br>';
    echo 'Número de libros no disponibles: ' . $numResultados - $disponibles;
    echo '<br>';

    // 3. Media de páginas
    $mediaPaginas = calcularMediaPaginas($catalogo);
    echo 'Media de páginas: ' . round($mediaPaginas, 2);

    // 4. Libro con mayor número de páginas

    // 5. Número de libros por género.

    // 6. Fecha y hora que se generó el informe
    date_default_timezone_set('Europe/Madrid');
    $timestamp = time();
    echo '<br>' . 'Fecha y hora: ' . date('d/m/Y H:i', $timestamp);
?>