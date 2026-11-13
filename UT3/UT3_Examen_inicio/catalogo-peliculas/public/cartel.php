<?php

declare(strict_types=1);

use App\Controlador\CartelControlador;

require dirname(__DIR__) . '/vendor/autoload.php';
(new CartelControlador())->mostrar();
