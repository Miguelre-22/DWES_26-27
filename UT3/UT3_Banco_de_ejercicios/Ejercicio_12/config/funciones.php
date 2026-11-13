<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function estructuraArchivoValida(mixed $archivo): bool
{
    return is_array($archivo)
        && isset($archivo['error'], $archivo['size'], $archivo['tmp_name'])
        && is_int($archivo['error'])
        && is_int($archivo['size'])
        && is_string($archivo['tmp_name']);
}
