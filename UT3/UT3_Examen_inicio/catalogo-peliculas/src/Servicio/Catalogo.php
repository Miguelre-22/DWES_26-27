<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Modelo\Pelicula;

final class Catalogo
{
    public function __construct(private array $peliculas)
    {
    }

    public function agregar(Pelicula $pelicula): void
    {
        $this->peliculas[] = $pelicula;
    }

    public function todos(): array
    {
        return $this->peliculas;
    }

    public function filtrar(string $q, string $genero): array
    {
        return array_values(
            array_filter(
                $this->peliculas,
                static function (Pelicula $pelicula) use ($q, $genero): bool {
                    $textoCoincide = $q === ''
                        || mb_stripos($pelicula->titulo(), $q, 0, 'UTF-8') !== false
                        || mb_stripos($pelicula->director(), $q, 0, 'UTF-8') !== false;

                    return $textoCoincide
                        && ($genero === '' || $pelicula->genero() === $genero);
                }
            )
        );
    }
}
