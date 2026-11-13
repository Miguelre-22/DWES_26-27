<?php

declare(strict_types=1);

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

final class LibroTest extends TestCase
{
    private Libro $libro;

    protected function setUp(): void
    {
        $this->libro = new Libro('Dune', 'Frank Herbert', 412);
    }

    public function testEstaDisponibleAlCrearlo(): void
    {
        $this->assertTrue($this->libro->estaDisponible());
    }

    public function testDejaDeEstarDisponibleAlPrestarlo(): void
    {
        $this->libro->prestar();

        $this->assertFalse($this->libro->estaDisponible());
    }
}
