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
}
