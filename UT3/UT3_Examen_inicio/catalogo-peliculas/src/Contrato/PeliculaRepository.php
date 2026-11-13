<?php

declare(strict_types=1);

namespace App\Contrato;

use App\Modelo\Pelicula;

interface PeliculaRepository
{
    public function buscarPorId(int $id): ?Pelicula;
}
