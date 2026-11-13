<?php

declare(strict_types=1);

require __DIR__ . '/config/funciones.php';

$compartida = in_array('compartida', $argv, true);

foreach (glob(DIRECTORIO_PORTADAS . '/*') as $archivo) {
    if (nombrePortadaValido(basename($archivo))) {
        unlink($archivo);
    }
}

$portadaA = bin2hex(random_bytes(16)) . '.png';
copy(__DIR__ . '/pruebas/portada-a.png', DIRECTORIO_PORTADAS . '/' . $portadaA);

guardarFichas([
    1 => ['titulo' => 'Dune', 'portada' => $portadaA],
    2 => ['titulo' => 'Solaris', 'portada' => $compartida ? $portadaA : null],
]);

echo 'Portada A: ', $portadaA, PHP_EOL;
echo 'Ficha 2 ', $compartida ? 'comparte' : 'no comparte', ' la portada A', PHP_EOL;
