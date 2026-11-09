<?php
declare(strict_types=1);

use App\Modelo\Material;

return [
    new Material('Balón de baloncesto', 'Cancha Sur', 24, 'colectivo'),
    new Material('Raqueta de bádminton', 'Red Ligera', 12, 'raqueta'),
    new Material('Esterilla de yoga', 'Movimiento Activo', 18, 'fitness', new DateTimeImmutable('2026-10-24')),
];
