<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ArchivoTemporalTest extends TestCase
{
    private string $ruta;

    protected function setUp(): void
    {
        $ruta = tempnam(sys_get_temp_dir(), 'ut3');
        if ($ruta === false) {
            $this->fail('No se pudo crear el archivo temporal.');
        }
        $this->ruta = $ruta;
    }

    protected function tearDown(): void
    {
        if (file_exists($this->ruta)) {
            unlink($this->ruta);
        }
        $this->assertFileDoesNotExist($this->ruta);
    }

    public function testEscribeEnElArchivoTemporal(): void
    {
        file_put_contents($this->ruta, 'Dune');

        $this->assertSame('Dune', file_get_contents($this->ruta));
    }
}
