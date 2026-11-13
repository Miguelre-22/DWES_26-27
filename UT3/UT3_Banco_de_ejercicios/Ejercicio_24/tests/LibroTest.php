<?php

declare(strict_types=1);

use App\Model\Libro;
use App\Model\LibroNoDisponibleException;
use PHPUnit\Framework\TestCase;

final class LibroTest extends TestCase
{
    public function testSegundoPrestamoLanzaExcepcion(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        $libro->prestar();

        $this->expectException(LibroNoDisponibleException::class);
        $libro->prestar();
    }

    public function testTituloVacioLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Libro('', 'Frank Herbert', 412);
    }

    public function testPaginasNegativasLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Libro('Dune', 'Frank Herbert', -1);
    }
}
