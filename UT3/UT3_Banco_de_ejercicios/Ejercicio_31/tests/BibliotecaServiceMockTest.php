<?php

declare(strict_types=1);

use App\Model\Libro;
use App\Repository\LibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

final class BibliotecaServiceMockTest extends TestCase
{
    public function testBuscaElLibroUnaVezYLoPresta(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        $repositorio = $this->createMock(LibroRepository::class);
        $repositorio->expects($this->once())
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($libro);
        $servicio = new BibliotecaService($repositorio);

        $servicio->prestar(1);

        $this->assertFalse($libro->estaDisponible());
    }
}
