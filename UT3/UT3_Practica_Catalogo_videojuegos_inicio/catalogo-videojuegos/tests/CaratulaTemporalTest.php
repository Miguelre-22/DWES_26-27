<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function App\Soporte\inspeccionarCaratula;

final class CaratulaTemporalTest extends TestCase
{
    private ?string $temporal = null;

    // COMPLETAR 10. setUp, prueba de rechazo y tearDown.
    protected function setUp(): void
    {
        $ruta = tempnam(sys_get_temp_dir(), 'ut3_');

        if ($ruta === false) {
            throw new RuntimeException('No se ha podido crear el temporal de prueba.');
        }

        $this->temporal = $ruta;
        file_put_contents($this->temporal, 'Esto es texto, no una imagen.');
    }

    public function testRechazaTextoComoCaratula(): void
    {
        $entrada = $this->entradaArchivo();

        $resultado = inspeccionarCaratula($entrada);

        $this->assertNull($resultado['archivo']);
        $this->assertNotNull($resultado['error']);
    }

    protected function tearDown(): void
    {
        if ($this->temporal !== null && file_exists($this->temporal)) {
            unlink($this->temporal);
        }

        if ($this->temporal !== null) {
            $this->assertFileDoesNotExist($this->temporal);
        }
    }

    // Proporcionado. Representa el temporal como entrada de inspeccionarCaratula.
    private function entradaArchivo(): array
    {
        if ($this->temporal === null || !is_file($this->temporal)) {
            throw new RuntimeException('El temporal de prueba no está preparado.');
        }

        return [
            'caratula' => [
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($this->temporal),
                'tmp_name' => $this->temporal,
            ],
        ];
    }
}
