<?php 
    $libros = [
        [
            'titulo' => 'Don Quijote de la Mancha',
            'autor' => 'Miguel de Cervantes',
        ],
        [
            'titulo' => 'Las tumbas de Atuán',
            'autor' => 'Ursula K. Le Guin',
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
        if($libro['autor'] === 'Ursula K. Le Guin'){
            echo "Autor: " . $libro['autor'] . "<br>" . "Titulo: " . $libro['titulo'];
        }
    }
?>