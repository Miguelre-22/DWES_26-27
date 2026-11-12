<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Clase\Alquileres\Modelo\EstadoAlquiler;
use Clase\Alquileres\Modelo\AlquilerBicicleta;
use Clase\Alquileres\Modelo\AlquilerPatinete;
use Clase\Alquileres\Servicio\ServicioAlquileres;

$alquileres =
    [
        new AlquilerBicicleta(501, 'Lucía Torres', 2, EstadoAlquiler::Reservado),
        new AlquilerPatinete(502, 'Álex Ruiz', 2, EstadoAlquiler::Activo),
        new AlquilerBicicleta(503, 'Óscar Gil', 3, EstadoAlquiler::Finalizado),
        new AlquilerPatinete(504, 'Lucía Molina', 1, EstadoAlquiler::Reservado)
    ];

$servicio = new ServicioAlquileres($alquileres);

function mostrar(
    string $titulo,
    array $alquileres,
    ServicioAlquileres $servicio
): void {
    echo $titulo . PHP_EOL;
    if ($alquileres === []) {
        echo 'Sin resultados' . PHP_EOL;
    }
    foreach ($alquileres as $a) {
        echo $a->id() . ' | ' . $a->cliente() . ' | ' . $a->modalidad()
            . ' | días: ' . $a->dias() . ' | ' . $a->estado()->value
            . ' | ' . $a->importe() . ' céntimos' . PHP_EOL;
    }
    $resumen = $servicio->resumir($alquileres);
    echo 'Cantidad: ' . $resumen['cantidad']
        . ' | Importe: ' . $resumen['importe'] . ' céntimos'
        . PHP_EOL . PHP_EOL;
};

mostrar('Colección inicial', $servicio->todos(), $servicio);



$datos_invalidos =
    [
        new AlquilerBicicleta(0, 'Lucía Torres', 2, EstadoAlquiler::Reservado)
    ];

$servicio = new ServicioAlquileres($datos_invalidos);

function mostrar2(
    string $titulo,
    array $alquileres,
    ServicioAlquileres $servicio
): void {
    echo $titulo . PHP_EOL;
    if ($alquileres === []) {
        echo 'Sin resultados' . PHP_EOL;
    }
    foreach ($alquileres as $a) {
        echo $a->id() . ' | ' . $a->cliente() . ' | ' . $a->modalidad()
            . ' | días: ' . $a->dias() . ' | ' . $a->estado()->value
            . ' | ' . $a->importe() . ' céntimos' . PHP_EOL;
    }
    $resumen = $servicio->resumir($alquileres);
    echo 'Cantidad: ' . $resumen['cantidad']
        . ' | Importe: ' . $resumen['importe'] . ' céntimos'
        . PHP_EOL . PHP_EOL;
};

mostrar2('Id a 0', $servicio->todos(), $servicio);
