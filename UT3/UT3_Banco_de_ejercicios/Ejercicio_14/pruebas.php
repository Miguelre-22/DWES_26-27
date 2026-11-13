<?php

declare(strict_types=1);

require __DIR__ . '/config/funciones.php';

foreach ([0, 1, 2097152, 2097153] as $tamano) {
    echo str_pad((string) $tamano, 10), tamanoValido($tamano) ? 'aceptado' : 'rechazado: máximo 2 MiB', PHP_EOL;
}
