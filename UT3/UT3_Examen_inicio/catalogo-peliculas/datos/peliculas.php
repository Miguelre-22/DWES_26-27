<?php

declare(strict_types=1);

use App\Modelo\Pelicula;

return [
    new Pelicula('Dune', 'Denis Villeneuve', 155, 'ciencia'),
    new Pelicula('El hobbit', 'Peter Jackson', 169, 'fantasia'),
    new Pelicula(
        'Solaris',
        'Andrei Tarkovski',
        167,
        'ciencia',
        new DateTimeImmutable('1972-03-20')
    ),
];
