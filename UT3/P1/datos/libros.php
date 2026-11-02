<?php

declare(strict_types=1);

use Miguel\Biblioteca\Modelo\LibroDigital;
use Miguel\Biblioteca\Modelo\LibroPapel;

return [
    new LibroPapel('Dune', 'Frank Herbert', 412, 'ciencia', 2, null, true, ''),
    new LibroDigital('Solaris', 'Stanislaw Lem', 240, 'ciencia', 3, null, false, ''),
    new LibroPapel('El hobbit', 'J. R. R. Tolkien', 310, 'fantasia', 1, null, false, ''),
    new LibroDigital('Drácula', 'Bram Stoker', 418, 'terror', 2, null, true, ''),
    new LibroPapel('Frankenstein', 'Mary Shelley', 280, 'terror', 2, null, false, ''),
    new LibroDigital('Terramar', 'Ursula K. Le Guin', 200, 'fantasia', 1, null, false, ''),
];
