<?php

declare(strict_types=1);

use App\Model\Libro;
use PHPUnit\Framework\TestCase;

final class LibroTest extends TestCase
{
    public function testPrestarDejaElLibroNoDisponible(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);

        $libro->prestar();

        $this->assertFalse($libro->estaDisponible());
    }
}
