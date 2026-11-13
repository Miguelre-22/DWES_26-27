<?php

declare(strict_types=1);

use App\Service\LibroFormService;
use App\Service\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LibroFormServicePaginasTest extends TestCase
{
    public static function paginas(): array
    {
        return [
            'mínimo' => ['1', true],
            'máximo' => ['3000', true],
            'cero' => ['0', false],
            'por encima del máximo' => ['3001', false],
            'con letras' => ['12abc', false],
            'decimal' => ['12.5', false],
            'array' => [['412'], false],
        ];
    }

    #[DataProvider('paginas')]
    public function testValidaPaginas(mixed $paginas, bool $aceptada): void
    {
        $servicio = new LibroFormService(new Validator());
        $entrada = [
            'titulo' => 'Dune',
            'autor' => 'Frank Herbert',
            'paginas' => '412',
            'genero' => 'ciencia',
            'fechaAlta' => '',
        ];
        $entrada['paginas'] = $paginas;

        $resultado = $servicio->procesar($entrada);

        if ($aceptada) {
            $this->assertArrayNotHasKey('paginas', $resultado['errores']);
            $this->assertSame((int) $paginas, $resultado['datos']['paginas']);
        } else {
            $this->assertArrayHasKey('paginas', $resultado['errores']);
            $this->assertNull($resultado['datos']);
        }
    }
}
