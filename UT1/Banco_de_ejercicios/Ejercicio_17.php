<?php
    $libros = [
        [
            'titulo' => 'Don Quijote de la Mancha',
            'autor' => 'Miguel de Cervantes',
        ],
        [
            'titulo' => 'Crimen y castigo',
            'autor' => 'Fiódor Dostoievski',
        ],
        [
            'titulo' => 'Orgullo y prejuicio',
            'autor' => 'Jane Austen',
        ],
        [
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
        ]
    ];

    foreach($libros as $libro){
        foreach($libro as $clave => $valor){
            echo "$clave: $valor<br>";
        };
        echo "<br>";
    };
?>