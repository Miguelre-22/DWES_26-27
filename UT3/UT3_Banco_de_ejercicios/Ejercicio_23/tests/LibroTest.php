<?php

declare(strict_types=1);

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

final class LibroTest extends TestCase
{
    public function testConservaTitulo(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);

        $this->assertSame('Dune', $libro->titulo());
    }

    public function testPrestarDejaElLibroNoDisponible(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);

        $libro->prestar();

        $this->assertFalse($libro->estaDisponible());
    }

    public function testConservaPaginasComoEntero(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);

        $this->assertSame(412, $libro->paginas());
    }

    public function testAssertEqualsAceptaEnteroYCadena(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);

        $this->assertEquals('412', $libro->paginas());
    }

    public function testAssertSameDistingueEnteroYCadena(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);

        $this->assertNotSame('412', $libro->paginas());
    }
}
