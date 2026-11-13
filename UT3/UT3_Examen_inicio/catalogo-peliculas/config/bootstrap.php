<?php

declare(strict_types=1);

use App\Servicio\Catalogo;

require_once dirname(__DIR__) . '/vendor/autoload.php';

return new Catalogo(require dirname(__DIR__) . '/datos/peliculas.php');
