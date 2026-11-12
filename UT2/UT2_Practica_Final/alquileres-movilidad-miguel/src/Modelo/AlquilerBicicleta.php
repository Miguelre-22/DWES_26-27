<?php

declare(strict_types=1);

namespace Clase\Alquileres\Modelo;

class AlquilerBicicleta extends Alquiler
{
    public function modalidad(): string
    {
        return 'bicicleta';
    }

    protected function tarifaDiaria(): int
    {
        return 500;
    }
}
