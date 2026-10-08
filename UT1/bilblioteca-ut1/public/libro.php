<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../src/datos.php';
    require_once __DIR__ . '/../src/funciones.php';

    // 1. Lee el id mediante GET
    $id = (int) ($_GET['id'] ?? '');

    $libro = obtenerporId($catalogo, $id);

    echo 'Id: ' . $libro['id'] . '<br>';
    echo 'Título: ' . htmlspecialchars($libro['titulo']) . '<br>';
    echo 'Autor: ' . htmlspecialchars($libro['autor']) . '<br>';
    echo 'Género: ' . htmlspecialchars($libro['genero']) . '<br>';
    echo 'Número de páginas: ' . $libro['paginas'] . '<br>' . 'Disponibilidad: ';
    echo $libro['disponible'] ? 'Disponible' : 'No disponible';
    echo '<br>';
    echo 'Fecha de alta: ' . htmlspecialchars($libro['fechaAlta']) . '<br>';
    echo '<hr>';
   
    // 6. Muestra cuántos días han pasado desde fechaAlta.
    $fechaAlta = new DateTimeImmutable($libro['fechaAlta']);
    $hoy = new DateTimeImmutable();
    $diferencia = $fechaAlta->diff($hoy);
    $diasPasados = $diferencia->days;
    echo 'Días desde el alta: ' . $diasPasados . '<br>';
    echo '<hr>';

    
    
?>