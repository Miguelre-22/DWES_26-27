<?php
namespace App\Repository;
use App\Model\Libro;
interface LibroRepository
{
    public function buscarPorId(int $id): ?Libro;
    public function guardar(Libro $libro): int;
    public function actualizar(int $id, Libro $libro): void;
}
