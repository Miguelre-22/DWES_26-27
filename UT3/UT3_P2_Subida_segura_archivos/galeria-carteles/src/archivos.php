<?php

declare(strict_types=1);

const TAMANO_MAXIMO = 2097152;
const POST_MAXIMO = 8 * 1024 * 1024;
const PATRON_NOMBRE = '/\A[a-f0-9]{32}\.(jpg|png|webp)\z/';
const TIPOS_PERMITIDOS = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
];

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function directorioCarteles(): string
{
    return __DIR__ . '/../storage/carteles';
}

function rutaCartel(string $nombre): string
{
    return directorioCarteles() . '/' . $nombre;
}

function postExcesivo(): bool
{
    $longitud = $_SERVER['CONTENT_LENGTH'] ?? '';
    return is_string($longitud) && ctype_digit($longitud) && (int) $longitud > POST_MAXIMO;
}

function estructuraValida(mixed $archivo): bool
{
    return is_array($archivo)
        && isset($archivo['error'], $archivo['size'], $archivo['tmp_name'])
        && is_int($archivo['error'])
        && is_int($archivo['size'])
        && is_string($archivo['tmp_name']);
}

function mensajeErrorSubida(int $codigo): string
{
    return match ($codigo) {
        UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Se ha superado el límite de recepción.',
        UPLOAD_ERR_PARTIAL => 'El archivo se ha recibido de forma parcial.',
        UPLOAD_ERR_CANT_WRITE => 'No se ha podido escribir el archivo recibido.',
        default => 'Error de recepción del archivo.',
    };
}

function tamanoValido(int $bytes): bool
{
    return $bytes >= 1 && $bytes <= TAMANO_MAXIMO;
}

function detectarMime(string $ruta): string|false
{
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->file($ruta);
}

function extensionPorMime(string|false $mime): ?string
{
    return $mime === false ? null : (TIPOS_PERMITIDOS[$mime] ?? null);
}

function nombreValido(mixed $nombre): bool
{
    return is_string($nombre) && preg_match(PATRON_NOMBRE, $nombre) === 1;
}

function cartelValido(mixed $nombre): ?array
{
    if (!nombreValido($nombre)) {
        return null;
    }
    $ruta = rutaCartel($nombre);
    if (!is_file($ruta) || !is_readable($ruta)) {
        return null;
    }
    $mime = detectarMime($ruta);
    if (extensionPorMime($mime) === null) {
        return null;
    }
    return ['nombre' => $nombre, 'ruta' => $ruta, 'mime' => $mime];
}

function listarCarteles(): ?array
{
    $rutas = glob(directorioCarteles() . '/*');
    if ($rutas === false) {
        return null;
    }
    $carteles = [];
    foreach ($rutas as $ruta) {
        $cartel = cartelValido(basename($ruta));
        if ($cartel !== null) {
            $carteles[] = $cartel;
        }
    }
    return $carteles;
}

function validarSubida(mixed $archivo): array
{
    if ($archivo === null) {
        return ['estado' => 'sin_archivo'];
    }
    if (!estructuraValida($archivo)) {
        return ['estado' => 'error', 'mensaje' => 'La entrada del archivo no tiene la estructura esperada.'];
    }
    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return ['estado' => 'sin_archivo'];
    }
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return ['estado' => 'error', 'mensaje' => mensajeErrorSubida($archivo['error'])];
    }
    if (!tamanoValido($archivo['size'])) {
        return ['estado' => 'error', 'mensaje' => 'La imagen debe ocupar entre 1 byte y 2 MiB.'];
    }
    $tmp = $archivo['tmp_name'];
    if (!is_file($tmp) || !is_readable($tmp)) {
        return ['estado' => 'error', 'mensaje' => 'No se puede leer el archivo recibido.'];
    }
    $extension = extensionPorMime(detectarMime($tmp));
    if ($extension === null) {
        return ['estado' => 'error', 'mensaje' => 'Formato no permitido. Solo se admiten JPEG, PNG y WebP.'];
    }
    return ['estado' => 'ok', 'tmp' => $tmp, 'ext' => $extension];
}

function guardarSubida(string $tmp, string $extension, ?string $anterior = null): array
{
    try {
        $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
    } catch (Throwable) {
        return ['ok' => false, 'mensaje' => 'No se ha podido preparar el archivo.'];
    }

    $directorio = directorioCarteles();
    if (!is_dir($directorio) || !is_writable($directorio)) {
        return ['ok' => false, 'mensaje' => 'No se ha podido guardar el cartel.'];
    }
    if ($nombre === $anterior || file_exists(rutaCartel($nombre))) {
        return ['ok' => false, 'mensaje' => 'No se ha podido preparar el archivo.'];
    }
    if (!move_uploaded_file($tmp, rutaCartel($nombre))) {
        return ['ok' => false, 'mensaje' => 'No se ha podido guardar el cartel.'];
    }
    return ['ok' => true, 'nombre' => $nombre];
}

function retirarArchivo(string $ruta): bool
{
    return is_file($ruta) && @unlink($ruta);
}