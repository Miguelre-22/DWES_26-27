<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Contrato\VideojuegoRepository;
use App\Modelo\Videojuego;
use OutOfBoundsException;

final class ConsultaVideojuego
{
    public function __construct(private VideojuegoRepository $repositorio)
    {
    }

    public function obtener(int $id): Videojuego
    {
        $videojuego = $this->repositorio->buscarPorId($id);

        if ($videojuego === null) {
            throw new OutOfBoundsException('Videojuego no encontrado.');
        }

        return $videojuego;
    }
}
