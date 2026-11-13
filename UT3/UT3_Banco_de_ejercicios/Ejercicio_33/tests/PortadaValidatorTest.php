<?php

declare(strict_types=1);

use App\Service\PortadaValidator;
use PHPUnit\Framework\TestCase;

final class PortadaValidatorTest extends TestCase
{
    private PortadaValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new PortadaValidator();
    }

    public function testAceptaUnByte(): void
    {
        $this->assertNull($this->validator->validar(1, 'image/png'));
    }

    public function testAceptaDosMiB(): void
    {
        $this->assertNull($this->validator->validar(2 * 1024 * 1024, 'image/png'));
    }

    public function testRechazaDosMiBMasUno(): void
    {
        $this->assertSame(
            'La portada debe ocupar entre 1 byte y 2 MiB.',
            $this->validator->validar(2 * 1024 * 1024 + 1, 'image/png')
        );
    }

    public function testAceptaPng(): void
    {
        $this->assertNull($this->validator->validar(1024, 'image/png'));
    }

    public function testRechazaTextoPlano(): void
    {
        $this->assertSame(
            'La portada debe ser JPEG, PNG o WebP.',
            $this->validator->validar(1024, 'text/plain')
        );
    }
}
