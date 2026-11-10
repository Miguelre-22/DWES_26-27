<?php
declare(strict_types=1);

use App\Controlador\AltaControlador;

$biblioteca = require dirname(__DIR__) . '/config/bootstrap.php';
(new AltaControlador($biblioteca))->mostrar();
