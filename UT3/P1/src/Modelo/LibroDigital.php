<?php

declare(strict_types=1);

namespace Miguel\Biblioteca\Modelo;

class LibroDigital extends Libro
{
    public function getTipo(): string
    {
        return 'digital';
    }

    public function costeReposicionCentimos(): int
    {
        return 400 * $this->unidades();
    }
}
