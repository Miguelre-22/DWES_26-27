<?php

declare(strict_types=1);

use App\Controlador\CaratulaControlador;

require dirname(__DIR__) . '/vendor/autoload.php';
(new CaratulaControlador())->mostrar();
