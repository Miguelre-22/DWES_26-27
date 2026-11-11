<?php

declare(strict_types=1);

namespace App\Contrato;

use App\Modelo\Videojuego;

interface VideojuegoRepository
{
    public function buscarPorId(int $id): ?Videojuego;
}
