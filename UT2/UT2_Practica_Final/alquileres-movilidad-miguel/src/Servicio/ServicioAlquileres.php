<?php

declare(strict_types=1);

namespace Clase\Alquileres\Servicio;

use Clase\Alquileres\Modelo\EstadoAlquiler;

class ServicioAlquileres
{
    private array $alquileres;

    public function __construct(array $alquileres)
    {
        $this->alquileres = $alquileres;
    }

    public function todos(): array
    {
        return $this->alquileres;
    }

    public function consultar(string $texto = '', ?EstadoAlquiler $estado = null): array
    {
        return $hola = [];
    }

    private function normalizar(string $texto): string
    {
        return trim(mb_strtolower($texto, 'UTF-8'));
    }

    public function resumir(array $alquileres): array
    {
        return $hola3 = [];
    }
}
