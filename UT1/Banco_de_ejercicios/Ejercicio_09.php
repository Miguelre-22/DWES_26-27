<?php
    $titulo = " El nombre del viento ";

    // Eliminar espacios exteriores
    $titulo = trim($titulo);

    // Calcular la longitud
    $longitud = strlen($titulo);

    // Comprobar si contiene la palabra "viento"
    $contiene = str_contains($titulo, "viento");

    // Sustituir "viento" por "fuego"
    $titulo = str_replace("viento", "fuego", $titulo);

    // Dividir en palabras
    $palabras = explode(" ", $titulo);

    echo "Título: " . $titulo . "<br>";
    echo "Longitud: " . $longitud . "<br>";
    echo "¿Contiene 'viento'? " . ($contiene ? "Sí" : "No") . "<br>";
    echo "Palabras:<br>";

    print_r($palabras);
?>