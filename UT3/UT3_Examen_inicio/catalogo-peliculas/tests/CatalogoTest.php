<?php

declare(strict_types=1);

use App\Modelo\Pelicula;
use PHPUnit\Framework\TestCase;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    public function testCompletar8(): void {
        $pelicula = new Pelicula(" Dune ", " Denis Villeneuve ", 155, 'ciencia');

        $this->assertSame("Dune", $pelicula->titulo());
        $this->assertSame("Denis Villeneuve", $pelicula->director());
        $this->assertSame(155, $pelicula->duracion());
        $this->assertNull($pelicula->fechaEstreno());
    }
}
