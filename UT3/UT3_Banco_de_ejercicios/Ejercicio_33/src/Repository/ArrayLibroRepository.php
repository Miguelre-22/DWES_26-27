<?php
declare(strict_types=1);
namespace App\Repository;
use App\Model\Libro;
use OutOfBoundsException;
final class ArrayLibroRepository implements LibroRepository
{
    private array $libros = [];
    private int $siguienteId = 1;
    public function buscarPorId(int $id): ?Libro
    { return $this->libros[$id] ?? null; }
    public function guardar(Libro $libro): int
    {
        $id = $this->siguienteId++;
        $this->libros[$id] = $libro;
        return $id;
    }
    public function actualizar(int $id, Libro $libro): void
    {
        if (!isset($this->libros[$id])) {
            throw new OutOfBoundsException('Libro no encontrado.');
        }
        $this->libros[$id] = $libro;
    }
    public function todos(): array { return $this->libros; }
}
