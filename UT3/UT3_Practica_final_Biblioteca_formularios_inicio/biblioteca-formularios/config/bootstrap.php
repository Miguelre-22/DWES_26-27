<?php
declare(strict_types=1);

use App\Servicio\Biblioteca;

require_once dirname(__DIR__) . '/vendor/autoload.php';

return new Biblioteca(require dirname(__DIR__) . '/datos/libros.php');
