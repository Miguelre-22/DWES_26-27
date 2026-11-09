<?php
declare(strict_types=1);

use App\Servicio\Inventario;

require_once dirname(__DIR__) . '/vendor/autoload.php';

return new Inventario(require dirname(__DIR__) . '/datos/materiales.php');
