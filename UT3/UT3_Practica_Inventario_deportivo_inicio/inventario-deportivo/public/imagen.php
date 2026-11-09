<?php
declare(strict_types=1);

use App\Controlador\ImagenControlador;

require dirname(__DIR__) . '/vendor/autoload.php';
(new ImagenControlador())->mostrar();
