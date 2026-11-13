<?php
declare(strict_types=1);
namespace App\Service;
final class Validator
{
    public function requerido(string $valor,
        string $mensaje): ?string
    {
        return trim($valor) === '' ? $mensaje : null;
    }
}
