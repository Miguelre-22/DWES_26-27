<?php

declare(strict_types=1);

namespace Clase\Alquileres\Modelo;

class AlquilerPatinete extends Alquiler
{
    public function modalidad(): string
    {
        return 'patinete';
    }

    protected function tarifaDiaria(): int
    {
        return 1000;
    }
}
