<?php
declare(strict_types=1);

use App\Controlador\AltaControlador;

$inventario = require dirname(__DIR__) . '/config/bootstrap.php';
(new AltaControlador($inventario))->mostrar();
