<?php

declare(strict_types=1);

use App\Contrato\VideojuegoRepository;
use App\Modelo\Videojuego;
use App\Servicio\ConsultaVideojuego;
use PHPUnit\Framework\TestCase;

final class ConsultaVideojuegoTest extends TestCase
{
    // COMPLETAR 11. Videojuego ausente con un stub.
    public function testVideojuegoAusenteLanzaExcepcion(): void
    {
        $repositorio = $this->createStub(VideojuegoRepository::class);
        $repositorio->method('buscarPorId')->willReturn(null);
        $consulta = new ConsultaVideojuego($repositorio);

        $this->expectException(OutOfBoundsException::class);

        $consulta->obtener(99);
    }

    // COMPLETAR 12. Consulta única del identificador con un mock.
    public function testObtenerConsultaElIdentificadorUnaVez(): void
    {
        $videojuego = new Videojuego('Torre de acero', 'Vector Games', 18, 'estrategia');

        $repositorio = $this->createMock(VideojuegoRepository::class);
        $repositorio->expects($this->once())
            ->method('buscarPorId')
            ->with(7)
            ->willReturn($videojuego);

        $consulta = new ConsultaVideojuego($repositorio);

        $resultado = $consulta->obtener(7);

        $this->assertSame($videojuego, $resultado);
    }
}
