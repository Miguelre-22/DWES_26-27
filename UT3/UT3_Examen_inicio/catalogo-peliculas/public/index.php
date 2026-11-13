<?php

declare(strict_types=1);

use App\Controlador\CatalogoControlador;

$catalogo = require dirname(__DIR__) . '/config/bootstrap.php';
(new CatalogoControlador($catalogo))->mostrar();
