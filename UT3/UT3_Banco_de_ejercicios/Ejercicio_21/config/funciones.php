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

const MIMES_PERMITIDOS = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];

function detectarMime(string $ruta): string|false
{
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->file($ruta);
}

function extensionPortada(array $archivo, array &$errores): ?string
{
    if (!tamanoValido($archivo['size'])) {
        $errores['portada'] = 'La portada debe ocupar entre 1 byte y 2 MiB.';
        return null;
    }
    $mime = detectarMime($archivo['tmp_name']);
    if ($mime === false) {
        $errores['portada'] = 'No se pudo comprobar el formato de la portada.';
        return null;
    }
    if (!isset(MIMES_PERMITIDOS[$mime])) {
        $errores['portada'] = 'La portada debe ser JPEG, PNG o WebP.';
        return null;
    }
    return MIMES_PERMITIDOS[$mime];
}

const DIRECTORIO_PORTADAS = __DIR__ . '/../storage/portadas';

function prepararDestino(string $extension, array &$errores): ?array
{
    try {
        $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
    } catch (Random\RandomException) {
        $errores[] = 'No se pudo preparar el nombre de la portada.';
        return null;
    }
    if (!is_dir(DIRECTORIO_PORTADAS) || !is_writable(DIRECTORIO_PORTADAS)) {
        $errores[] = 'El almacenamiento de portadas no está disponible.';
        return null;
    }
    $destino = DIRECTORIO_PORTADAS . '/' . $nombre;
    if (file_exists($destino)) {
        $errores[] = 'No se pudo preparar la portada. Vuelve a intentarlo.';
        return null;
    }
    return ['nombre' => $nombre, 'destino' => $destino];
}

function validarFicha(array $entrada): array
{
    $valores = ['titulo' => '', 'paginas' => ''];
    $errores = [];
    foreach (['titulo', 'paginas'] as $campo) {
        $dato = $entrada[$campo] ?? '';
        if (!is_string($dato)) {
            $errores[$campo] = 'Debe ser texto.';
        } else {
            $valores[$campo] = trim($dato);
        }
    }
    if (!isset($errores['titulo'])) {
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'El título es obligatorio.';
        } elseif (mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'Máximo 120 caracteres.';
        }
    }
    $paginas = false;
    if (!isset($errores['paginas'])) {
        $paginas = filter_var($valores['paginas'], FILTER_VALIDATE_INT);
        if ($paginas === false || $paginas < 1 || $paginas > 3000) {
            $errores['paginas'] = 'Entre 1 y 3000 páginas.';
        }
    }
    return [
        'valores' => $valores,
        'errores' => $errores,
        'datos' => $errores === [] ? ['titulo' => $valores['titulo'], 'paginas' => $paginas] : null,
    ];
}
