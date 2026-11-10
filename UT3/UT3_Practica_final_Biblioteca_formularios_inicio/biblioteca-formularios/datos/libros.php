<?php
declare(strict_types=1);

use App\Modelo\Libro;

return [
    new Libro('Dune', 'Frank Herbert', 412, 'ciencia'),
    new Libro('El hobbit', 'J. R. R. Tolkien', 310, 'fantasia'),
    new Libro('Solaris', 'Stanislaw Lem', 240, 'ciencia', new DateTimeImmutable('2026-10-24')),
];
