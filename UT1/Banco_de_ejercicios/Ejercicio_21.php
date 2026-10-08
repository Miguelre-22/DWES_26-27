<?php
    $novedades1 = ["Dune", "El Hobbit", "1984"];
    $novedades2 = ["Fundación", "Drácula", "It"];

    // Combinar los dos arrays
    $novedades = array_merge($novedades1, $novedades2);


    // Eliminar un elemento
    unset($novedades[2]);

    // Volver a poner los índices consecutivos
    $novedades = array_values($novedades);

    foreach ($novedades as $novedad) {
        echo $novedad . "<br>";
    }
?>