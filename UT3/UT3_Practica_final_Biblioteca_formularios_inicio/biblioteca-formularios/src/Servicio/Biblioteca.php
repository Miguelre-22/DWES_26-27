<?php
declare(strict_types=1);
namespace App\Servicio;

use App\Modelo\Libro;

final class Biblioteca
{
    public function __construct(private array $libros) {}

    public function agregar(Libro $libro): void { $this->libros[] = $libro; }
    public function todos(): array { return $this->libros; }

    public function filtrar(string $q, string $genero): array
    {
        return array_values(array_filter($this->libros,
            static function (Libro $libro) use ($q, $genero): bool {
                $textoCoincide = $q === ''
                    || mb_stripos($libro->titulo(), $q, 0, 'UTF-8') !== false
                    || mb_stripos($libro->autor(), $q, 0, 'UTF-8') !== false;
                return $textoCoincide
                    && ($genero === '' || $libro->genero() === $genero);
            }));
    }
}
