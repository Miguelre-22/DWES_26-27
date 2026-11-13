<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Modelo\Videojuego;

final class Catalogo
{
    public function __construct(private array $videojuegos)
    {
    }

    public function agregar(Videojuego $videojuego): void
    {
        $this->videojuegos[] = $videojuego;
    }

    public function todos(): array
    {
        return $this->videojuegos;
    }

    public function filtrar(string $q, string $genero): array
    {
        return array_values(
            array_filter(
                $this->videojuegos,
                static function (Videojuego $videojuego) use ($q, $genero): bool {
                    $textoCoincide = $q === ''
                        || mb_stripos($videojuego->titulo(), $q, 0, 'UTF-8') !== false
                        || mb_stripos($videojuego->estudio(), $q, 0, 'UTF-8') !== false;

                    return $textoCoincide
                        && ($genero === '' || $videojuego->genero() === $genero);
                }
            )
        );
    }
}
