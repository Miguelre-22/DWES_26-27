<?php
    $libro = [
        'id' => 100,
        'titulo' => 'El Quijote',
        'autor' => 'Miguel de Cervantes',
        'paginas' => 54,
        'disponible' => true,
    ];

    $libro['disponible'] = false;

    foreach ($libro as $clave => $valor){
        echo "$clave: $valor<br>";
    };
?>