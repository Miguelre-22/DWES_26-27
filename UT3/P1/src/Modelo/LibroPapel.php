<?php

declare(strict_types=1);

namespace Miguel\Biblioteca\Modelo;

class LibroPapel extends Libro
{
    public function getTipo(): string
    {
        return 'papel';
    }

    public function costeReposicionCentimos(): int
    {
        return $this->paginas() * 5 * $this->unidades();
    }
}
