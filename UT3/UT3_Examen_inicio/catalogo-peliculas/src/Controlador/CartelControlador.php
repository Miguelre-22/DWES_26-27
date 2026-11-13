<?php

declare(strict_types=1);

namespace App\Controlador;

use finfo;

use const App\Soporte\MIME_CARTELES;

use function App\Soporte\directorioCarteles;

final class CartelControlador
{
    public function mostrar(): void
    {
        // Proporcionado. Publica únicamente nombres generados dentro de la carpeta fija.
        $nombre = $_GET['nombre'] ?? null;

        if (
            !is_string($nombre)
            || preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) !== 1
        ) {
            http_response_code(404);
            exit;
        }

        $ruta = directorioCarteles() . '/' . $nombre;
        $mime = is_file($ruta) && !is_link($ruta) && is_readable($ruta)
            ? (new finfo(FILEINFO_MIME_TYPE))->file($ruta)
            : false;

        if (
            $mime === false || !isset(MIME_CARTELES[$mime])
            || pathinfo($nombre, PATHINFO_EXTENSION) !== MIME_CARTELES[$mime]
        ) {
            http_response_code(404);
            exit;
        }
        // COMPLETAR 7. Cabeceras y envío del archivo validado.
        header('Content-Type: ' . $mime);
        header('X-Content-Type-Options: nosniff');
        readfile($ruta);
        exit;
    }
}
