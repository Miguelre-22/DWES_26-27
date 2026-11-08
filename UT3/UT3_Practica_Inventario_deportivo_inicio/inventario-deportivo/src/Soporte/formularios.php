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
    $r = leerTextos($entrada, ['q', 'categoria']);
    if (!isset($r['errores']['q']) && mb_strlen($r['valores']['q'], 'UTF-8') > 120) {
        $r['errores']['q'] = 'La búsqueda admite hasta 120 caracteres.';
    }
    if (!isset($r['errores']['categoria']) && !in_array(
        $r['valores']['categoria'], ['', 'colectivo', 'raqueta', 'fitness'], true)) {
        $r['errores']['categoria'] = 'Elige una categoría válida.';
    }
    return $r;
}

function validarMaterial(array $entrada): array
{
    $r = leerTextos($entrada, ['nombre', 'fabricante', 'unidades', 'categoria', 'fechaAlta']);
    $v = $r['valores'];
    $errores = $r['errores'];
    foreach (['nombre' => 120, 'fabricante' => 100] as $campo => $maximo) {
        if (isset($errores[$campo])) { continue; }
        if ($v[$campo] === '') {
            $errores[$campo] = 'Este campo es obligatorio.';
        } elseif (mb_strlen($v[$campo], 'UTF-8') > $maximo) {
            $errores[$campo] = 'Admite hasta ' . $maximo . ' caracteres.';
        }
    }
    $unidades = filter_var($v['unidades'], FILTER_VALIDATE_INT);
    if (!isset($errores['unidades'])
        && ($unidades === false || $unidades < 1 || $unidades > 3000)) {
        $errores['unidades'] = 'Introduce un entero entre 1 y 3000.';
    }
    if (!isset($errores['categoria'])
        && !in_array($v['categoria'], ['colectivo', 'raqueta', 'fitness'], true)) {
        $errores['categoria'] = 'Elige una categoría válida.';
    }
    $fecha = null;
    if (!isset($errores['fechaAlta']) && $v['fechaAlta'] !== '') {
        try {
            $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $v['fechaAlta']);
        } catch (ValueError) { $fecha = false; }
        if ($fecha === false || $fecha->format('Y-m-d') !== $v['fechaAlta']) {
            $errores['fechaAlta'] = 'Introduce una fecha posible con formato YYYY-MM-DD.';
        }
    }
    return ['valores' => $v, 'errores' => $errores, 'datos' => $errores === [] ? [
        'nombre' => $v['nombre'], 'fabricante' => $v['fabricante'], 'unidades' => $unidades,
        'categoria' => $v['categoria'], 'fechaAlta' => $fecha,
    ] : null];
}
