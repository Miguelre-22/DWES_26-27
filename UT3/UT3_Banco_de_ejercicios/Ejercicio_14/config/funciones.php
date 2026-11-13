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

function estadoRecepcion(mixed $archivo, array &$errores): string
{
    if ($archivo === null) {
        return 'ausente';
    }
    if (!estructuraArchivoValida($archivo)) {
        $errores['portada'] = 'La portada no tiene la estructura esperada.';
        return 'error';
    }
    switch ($archivo['error']) {
        case UPLOAD_ERR_NO_FILE:
            return 'sin_archivo';
        case UPLOAD_ERR_OK:
            return 'recibido';
        case UPLOAD_ERR_INI_SIZE:
            $errores['portada'] = 'La portada supera el tamaño que admite el servidor.';
            return 'error';
        case UPLOAD_ERR_PARTIAL:
            $errores['portada'] = 'La portada se recibió de forma incompleta.';
            return 'error';
        default:
            $errores['portada'] = 'No se pudo recibir la portada.';
            return 'error';
    }
}

const TAMANO_MAXIMO = 2 * 1024 * 1024;

function tamanoValido(int $tamano): bool
{
    return $tamano >= 1 && $tamano <= TAMANO_MAXIMO;
}
