<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Contrato\PeliculaRepository;
use App\Modelo\Pelicula;
use OutOfBoundsException;

final class ConsultaPelicula
{
    public function __construct(private PeliculaRepository $repositorio)
    {
    }

    public function obtener(int $id): Pelicula
    {
        $pelicula = $this->repositorio->buscarPorId($id);

        if ($pelicula === null) {
            throw new OutOfBoundsException('Película no encontrada.');
        }

        return $pelicula;
    }
}
