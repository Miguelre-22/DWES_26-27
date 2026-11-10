<?php
declare(strict_types=1);
namespace App\Soporte;

use finfo;
use RuntimeException;
use Throwable;


const MIME_PORTADAS = [
    'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp',
];

function directorioPortadas(): string
{
    return dirname(__DIR__, 2) . '/storage/portadas';
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
function recibirPortada(array $archivos): array
{
    if (!array_key_exists('portada', $archivos)) {
        return ['archivo' => null, 'error' => null];
    }
    $a = $archivos['portada'];
    if (!is_array($a) || !isset($a['error'], $a['size'], $a['tmp_name'])
        || !is_int($a['error']) || !is_int($a['size']) || !is_string($a['tmp_name'])) {
        return ['archivo' => null, 'error' => 'La entrada de la portada no es válida.'];
    }
    if ($a['error'] === UPLOAD_ERR_NO_FILE) {
        return ['archivo' => null, 'error' => null];
    }
    if ($a['error'] !== UPLOAD_ERR_OK) {
        $mensaje = match ($a['error']) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'La portada supera el límite de recepción.',
            UPLOAD_ERR_PARTIAL => 'La portada ha llegado incompleta.',
            UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'No se ha podido recibir la portada.',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP ha detenido la subida.',
            default => 'Error de recepción de la portada.',
        };
        return ['archivo' => null, 'error' => $mensaje];
    }
    return ['archivo' => $a, 'error' => null];
}

function inspeccionarPortada(array $archivos): array
{
    $r = recibirPortada($archivos);
    if ($r['error'] !== null || $r['archivo'] === null) { return $r; }
    $a = $r['archivo'];
    // COMPLETAR 6. Tamaño, temporal legible y MIME. No mover aquí el archivo.
    if ($a['size'] < 1 || $a['size'] > 2097152) {
        return ['archivo' => null, 'error' => 'Error: el tamaño es incorrecto.'];
    }
    if (!is_file($a['tmp_name']) || !is_readable($a['tmp_name'])) {
        return ['archivo' => null, 'error' => 'Error: la ruta no es un archivo o este no se puede leer.'];
    }
    $detector = new finfo(FILEINFO_MIME_TYPE);
    $mime = $detector->file($a['tmp_name']);
    if ($mime === false || !array_key_exists($mime, MIME_PORTADAS)) {
        return ['archivo' => null, 'error' => 'Error: el formato no es uno de los permitidos.'];
    }
    $a['extension'] = MIME_PORTADAS[$mime];
    return ['archivo' => $a, 'error' => null];
}

// Proporcionado. Recibe una extensión ya obtenida de MIME_PORTADAS.
function prepararDestino(string $extension): array
{
    if (!in_array($extension, array_values(MIME_PORTADAS), true)) {
        throw new RuntimeException('La extensión de la portada no es válida.');
    }
    $directorio = directorioPortadas();
    if (!is_dir($directorio) || !is_writable($directorio)) {
        throw new RuntimeException('El almacenamiento de portadas no está disponible.');
    }
    try { $nombre = bin2hex(random_bytes(16)) . '.' . $extension; }
    catch (Throwable $error) {
        throw new RuntimeException('No se ha podido preparar el nombre de la portada.', 0, $error);
    }
    $ruta = $directorio . '/' . $nombre;
    if (file_exists($ruta) || is_link($ruta)) {
        throw new RuntimeException('El nombre ya está ocupado. Vuelve a enviar.');
    }
    return ['nombre' => $nombre, 'ruta' => $ruta];
}
