<?php

declare(strict_types=1);

namespace App\Soporte;

use DateTimeImmutable;
use ValueError;

// Proporcionado. Los textos se conservan sin escapar; e() se usa al mostrar HTML.
function leerTextos(array $entrada, array $campos): array
{
    $valores = [];
    $errores = [];

    foreach ($campos as $campo) {
        $valor = $entrada[$campo] ?? '';

        if (array_key_exists($campo, $entrada) && !is_string($entrada[$campo])) {
            $errores[$campo] = 'Debes enviar un texto.';
            $valor = '';
        }

        $valores[$campo] = trim($valor);
    }

    return ['valores' => $valores, 'errores' => $errores];
}

function validarFiltros(array $entrada): array
{
    $r = leerTextos($entrada, ['q', 'genero']);

    if (!isset($r['errores']['q']) && mb_strlen($r['valores']['q'], 'UTF-8') > 120) {
        $r['errores']['q'] = 'La búsqueda admite hasta 120 caracteres.';
    }

    if (
        !isset($r['errores']['genero']) && !in_array(
            $r['valores']['genero'],
            ['', 'aventura', 'estrategia', 'rol'],
            true
        )
    ) {
        $r['errores']['genero'] = 'Elige un género válido.';
    }

    return $r;
}

function validarVideojuego(array $entrada): array
{
    $r = leerTextos($entrada, ['titulo', 'estudio', 'horas', 'genero', 'fechaLanzamiento']);
    $v = $r['valores'];
    $errores = $r['errores'];

    foreach (['titulo' => 120, 'estudio' => 100] as $campo => $maximo) {
        if (isset($errores[$campo])) {
            continue;
        }

        if ($v[$campo] === '') {
            $errores[$campo] = 'Este campo es obligatorio.';
        } elseif (mb_strlen($v[$campo], 'UTF-8') > $maximo) {
            $errores[$campo] = 'Admite hasta ' . $maximo . ' caracteres.';
        }
    }

    $horas = filter_var($v['horas'], FILTER_VALIDATE_INT);

    if (
        !isset($errores['horas'])
        && ($horas === false || $horas < 1 || $horas > 300)
    ) {
        $errores['horas'] = 'Introduce un entero entre 1 y 300.';
    }

    if (
        !isset($errores['genero'])
        && !in_array($v['genero'], ['aventura', 'estrategia', 'rol'], true)
    ) {
        $errores['genero'] = 'Elige un género válido.';
    }

    $fecha = null;

    if (!isset($errores['fechaLanzamiento']) && $v['fechaLanzamiento'] !== '') {
        try {
            $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $v['fechaLanzamiento']);
        } catch (ValueError) {
            $fecha = false;
        }

        if ($fecha === false || $fecha->format('Y-m-d') !== $v['fechaLanzamiento']) {
            $errores['fechaLanzamiento'] = 'Introduce una fecha posible con formato YYYY-MM-DD.';
        }
    }

    return [
        'valores' => $v,
        'errores' => $errores,
        'datos' => $errores === [] ? [
            'titulo' => $v['titulo'],
            'estudio' => $v['estudio'],
            'horas' => $horas,
            'genero' => $v['genero'],
            'fechaLanzamiento' => $fecha,
        ] : null
    ];
}
