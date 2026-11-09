<?php
declare(strict_types=1);

use App\Controlador\CatalogoControlador;

$inventario = require dirname(__DIR__) . '/config/bootstrap.php';
(new CatalogoControlador($inventario))->mostrar();
