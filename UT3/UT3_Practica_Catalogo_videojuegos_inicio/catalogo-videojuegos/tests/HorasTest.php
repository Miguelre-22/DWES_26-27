<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarVideojuego;

final class HorasTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de los cinco valores de horas.
    public static function casosHoras(): array
    {
        return [
            'mínimo'         => ['1', true],
            'máximo'         => ['300', true],
            'cero'           => ['0', false],
            'mayor que 300'  => ['301', false],
            'texto mezclado' => ['12abc', false],
        ];
    }

    #[DataProvider('casosHoras')]
    public function testValidacionDeHoras(string $entrada, bool $valida): void
    {
        $post = $this->datosValidos();
        $post['horas'] = $entrada;

        $resultado = validarVideojuego($post);

        if ($valida) {
            $this->assertArrayNotHasKey('horas', $resultado['errores']);
            $this->assertIsInt($resultado['datos']['horas']);
            $this->assertSame((int) $entrada, $resultado['datos']['horas']);
        } else {
            $this->assertArrayHasKey('horas', $resultado['errores']);
            $this->assertNull($resultado['datos']);
        }
    }

    // Proporcionado. Datos válidos sobre los que varías solo horas.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Islas de cristal',
            'estudio' => 'Nébula Studio',
            'horas' => '35',
            'genero' => 'aventura',
            'fechaLanzamiento' => '',
        ];
    }
}
