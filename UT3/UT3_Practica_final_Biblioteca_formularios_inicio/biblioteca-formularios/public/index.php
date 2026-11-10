<?php
declare(strict_types=1);

use App\Controlador\CatalogoControlador;

$biblioteca = require dirname(__DIR__) . '/config/bootstrap.php';
(new CatalogoControlador($biblioteca))->mostrar();
