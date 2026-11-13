<?php

declare(strict_types=1);

use App\Repository\LibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

final class BibliotecaServiceStubTest extends TestCase
{
    public function testLibroInexistenteLanzaExcepcion(): void
    {
        $repositorio = $this->createStub(LibroRepository::class);
        $repositorio->method('buscarPorId')->willReturn(null);
        $servicio = new BibliotecaService($repositorio);

        $this->expectException(OutOfBoundsException::class);
        $servicio->prestar(999);
    }
}
