<?php

declare(strict_types=1);

use App\Modelo\Videojuego;

return [
    new Videojuego('Islas de cristal', 'Nébula Studio', 35, 'aventura'),
    new Videojuego('Torre de acero', 'Vector Games', 18, 'estrategia'),
    new Videojuego(
        'Bosque ancestral',
        'Raíz Digital',
        60,
        'aventura',
        new DateTimeImmutable('2026-03-20')
    ),
];
