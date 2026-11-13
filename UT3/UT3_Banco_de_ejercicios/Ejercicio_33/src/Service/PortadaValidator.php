<?php

declare(strict_types=1);

namespace App\Service;

final class PortadaValidator
{
    public const TAMANO_MAXIMO = 2 * 1024 * 1024;
    public const MIMES_PERMITIDOS = ['image/jpeg', 'image/png', 'image/webp'];

    public function validar(int $tamano, string $mime): ?string
    {
        if ($tamano < 1 || $tamano > self::TAMANO_MAXIMO) {
            return 'La portada debe ocupar entre 1 byte y 2 MiB.';
        }
        if (!in_array($mime, self::MIMES_PERMITIDOS, true)) {
            return 'La portada debe ser JPEG, PNG o WebP.';
        }
        return null;
    }
}
