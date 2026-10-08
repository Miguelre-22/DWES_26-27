<?php
    $generos = ['Terror', 'Fantasía', 'Acción', 'Comedia', 'Infantil'];
    $generos[] = 'Ciencia Ficción';
    $generos[2] = 'Didácticos';
    unset($generos[0]);
    foreach ($generos as $genero){
        echo $genero . "<br>";
    }
?>