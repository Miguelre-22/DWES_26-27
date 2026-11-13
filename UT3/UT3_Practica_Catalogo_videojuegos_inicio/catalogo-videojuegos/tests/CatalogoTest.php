<?php

declare(strict_types=1);

use App\Modelo\Videojuego;
use PHPUnit\Framework\TestCase;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    public function testCreacionValidaRecortaTextos(): void
    {
        $videojuego = new Videojuego(' Islas de cristal ', ' Nébula Studio ', 35, 'aventura');

        $this->assertSame('Islas de cristal', $videojuego->titulo());
        $this->assertSame('Nébula Studio', $videojuego->estudio());
        $this->assertSame(35, $videojuego->horas());
        $this->assertNull($videojuego->fechaLanzamiento());
    }
}
