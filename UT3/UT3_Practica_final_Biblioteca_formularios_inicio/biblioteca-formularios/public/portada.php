<?php
declare(strict_types=1);

use App\Controlador\PortadaControlador;

require dirname(__DIR__) . '/vendor/autoload.php';
(new PortadaControlador())->mostrar();
