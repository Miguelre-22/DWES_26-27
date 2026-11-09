<?php
declare(strict_types=1);
namespace App\Soporte;

use finfo;
use RuntimeException;
use Throwable;


const MIME_IMAGENES = [
    'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp',
];

function directorioImagenes(): string
{
    return dirname(__DIR__, 2) . '/storage/imagenes';
}

// Proporcionado. Detecta peticiones que PHP ha descartado por su tamaño total.
function postExcesivo(): bool
{
    $limite = trim((string) ini_get('post_max_size'));
    if ($limite === '' || $limite === '0') { return false; }
    $unidad = strtolower(substr($limite, -1));
    $factor = match ($unidad) { 'g' => 1024 ** 3, 'm' => 1024 ** 2, 'k' => 1024, default => 1 };
    return (float) ($_SERVER['CONTENT_LENGTH'] ?? 0) > (float) $limite * $factor;
}

// Proporcionado. La ausencia es admisible, pero una entrada presente mal formada no.
function recibirImagen(array $archivos): array
{
    if (!array_key_exists('imagen', $archivos)) {
        return ['archivo' => null, 'error' => null];
    }
    $a = $archivos['imagen'];
    if (!is_array($a) || !isset($a['error'], $a['size'], $a['tmp_name'])
        || !is_int($a['error']) || !is_int($a['size']) || !is_string($a['tmp_name'])) {
        return ['archivo' => null, 'error' => 'La entrada de la imagen no es válida.'];
    }
    if ($a['error'] === UPLOAD_ERR_NO_FILE) {
        return ['archivo' => null, 'error' => null];
    }
    if ($a['error'] !== UPLOAD_ERR_OK) {
        $mensaje = match ($a['error']) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'La imagen supera el límite de recepción.',
            UPLOAD_ERR_PARTIAL => 'La imagen ha llegado incompleta.',
            UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'No se ha podido recibir la imagen.',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP ha detenido la subida.',
            default => 'Error de recepción de la imagen.',
        };
        return ['archivo' => null, 'error' => $mensaje];
    }
    return ['archivo' => $a, 'error' => null];
}

function inspeccionarImagen(array $archivos): array
{
    $r = recibirImagen($archivos);
    if ($r['error'] !== null || $r['archivo'] === null) { return $r; }
    $a = $r['archivo'];
    // COMPLETAR 6. Tamaño, temporal legible y MIME. No mover aquí el archivo.
     if ($a['size'] < 1 || $a['size'] > 2097152) {
        return ['archivo' => null, 'error' => 'La imagen debe ocupar entre 1 byte y 2 MiB.'];
    }

    if (!is_file($a['tmp_name']) || !is_readable($a['tmp_name'])) {
        return ['archivo' => null, 'error' => 'No se ha podido leer la imagen recibida.'];
    }

    $detector = new finfo(FILEINFO_MIME_TYPE);
    $mime = $detector->file($a['tmp_name']);
    if ($mime === false || !array_key_exists($mime, MIME_IMAGENES)) {
        return ['archivo' => null, 'error' => 'El formato de la imagen no está permitido.'];
    }

    $a['extension'] = MIME_IMAGENES[$mime];
    return ['archivo' => $a, 'error' => null];
}

// Proporcionado. Recibe una extensión ya obtenida de MIME_IMAGENES.
function prepararDestino(string $extension): array
{
    if (!in_array($extension, array_values(MIME_IMAGENES), true)) {
        throw new RuntimeException('La extensión de la imagen no es válida.');
    }
    $directorio = directorioImagenes();
    if (!is_dir($directorio) || !is_writable($directorio)) {
        throw new RuntimeException('El almacenamiento de imagenes no está disponible.');
    }
    try { $nombre = bin2hex(random_bytes(16)) . '.' . $extension; }
    catch (Throwable $error) {
        throw new RuntimeException('No se ha podido preparar el nombre de la imagen.', 0, $error);
    }
    $ruta = $directorio . '/' . $nombre;
    if (file_exists($ruta) || is_link($ruta)) {
        throw new RuntimeException('El nombre ya está ocupado. Vuelve a enviar.');
    }
    return ['nombre' => $nombre, 'ruta' => $ruta];
}
