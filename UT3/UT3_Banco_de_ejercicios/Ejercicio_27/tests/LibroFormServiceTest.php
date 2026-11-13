<?php

declare(strict_types=1);

use App\Service\LibroFormService;
use App\Service\Validator;
use PHPUnit\Framework\TestCase;

final class LibroFormServiceTest extends TestCase
{
    private function entradaValida(): array
    {
        return [
            'titulo' => ' Dune ',
            'autor' => 'Frank Herbert',
            'paginas' => '412',
            'genero' => 'ciencia',
            'fechaAlta' => '',
        ];
    }

    private function procesar(array $cambios = []): array
    {
        $servicio = new LibroFormService(new Validator());
        return $servicio->procesar(array_replace($this->entradaValida(), $cambios));
    }

    public function testProcesaUnaFichaValida(): void
    {
        $resultado = $this->procesar();

        $this->assertSame('412', $resultado['valores']['paginas']);
        $this->assertSame('Dune', $resultado['valores']['titulo']);
        $this->assertSame([], $resultado['errores']);
        $this->assertSame(412, $resultado['datos']['paginas']);
        $this->assertSame('Dune', $resultado['datos']['titulo']);
        $this->assertNull($resultado['datos']['fechaAlta']);
    }

    public function testFechaValida(): void
    {
        $resultado = $this->procesar(['fechaAlta' => '2026-10-24']);

        $this->assertSame([], $resultado['errores']);
        $this->assertInstanceOf(DateTimeImmutable::class, $resultado['datos']['fechaAlta']);
        $this->assertSame('2026-10-24', $resultado['datos']['fechaAlta']->format('Y-m-d'));
    }

    public function testFechaImposible(): void
    {
        $resultado = $this->procesar(['fechaAlta' => '2026-02-31']);

        $this->assertArrayHasKey('fechaAlta', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }

    public function testTituloDe120Caracteres(): void
    {
        $titulo = str_repeat('a', 120);

        $resultado = $this->procesar(['titulo' => $titulo]);

        $this->assertSame([], $resultado['errores']);
        $this->assertSame($titulo, $resultado['datos']['titulo']);
    }

    public function testTituloDe121Caracteres(): void
    {
        $resultado = $this->procesar(['titulo' => str_repeat('a', 121)]);

        $this->assertArrayHasKey('titulo', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }

    public function testTituloArrayConservaErrorDeTipo(): void
    {
        $resultado = $this->procesar(['titulo' => ['Dune']]);

        $this->assertSame('Debe ser texto.', $resultado['errores']['titulo']);
        $this->assertSame('', $resultado['valores']['titulo']);
        $this->assertNull($resultado['datos']);
    }

    public function testGeneroNoPermitido(): void
    {
        $resultado = $this->procesar(['genero' => 'aventura']);

        $this->assertArrayHasKey('genero', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }
}
