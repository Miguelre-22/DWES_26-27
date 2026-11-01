<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Miguel\Biblioteca\Modelo\LibroDigital;
use Miguel\Biblioteca\Modelo\LibroPapel;
use Miguel\Biblioteca\Servicio\BibliotecaService;

$libros = require dirname(__DIR__) . '/datos/libros.php';
$servicio = new BibliotecaService($libros);

$valores = [
    'tipo' => '',
    'titulo' => '',
    'autor' => '',
    'paginas' => '',
    'genero' => '',
    'unidades' => '',
    'fechaAlta' => '',
    'destacado' => false,
    'observaciones' => '',
    'correo' => '',
];
$errores = [];
$ficha = null;
$filas = [];
$resumen = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $camposTexto = ['tipo', 'titulo', 'autor', 'paginas', 'genero', 'unidades', 'fechaAlta', 'observaciones', 'correo'];

    foreach ($camposTexto as $campo) {
        $dato = $_POST[$campo] ?? '';
        if (!is_string($dato)) {
            $errores[$campo] = 'Tipo de dato no válido.';
            $valores[$campo] = '';
            continue;
        }
        $valores[$campo] = trim($dato);
    }

    if (!isset($errores['tipo']) && !in_array($valores['tipo'], ['papel', 'digital'], true)) {
        $errores['tipo'] = 'Elige papel o digital.';
    }

    if (!isset($errores['titulo'])) {
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'El título es obligatorio.';
        } elseif (mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'El título admite hasta 120 caracteres.';
        }
    }

    if (!isset($errores['autor'])) {
        if ($valores['autor'] === '') {
            $errores['autor'] = 'El autor es obligatorio.';
        } elseif (mb_strlen($valores['autor'], 'UTF-8') > 100) {
            $errores['autor'] = 'El autor admite hasta 100 caracteres.';
        }
    }

    $paginas = false;
    if (!isset($errores['paginas'])) {
        $paginas = filter_var($valores['paginas'], FILTER_VALIDATE_INT);
        if ($paginas === false) {
            $errores['paginas'] = 'Las páginas deben ser un número entero.';
        } elseif ($paginas < 1 || $paginas > 3000) {
            $errores['paginas'] = 'Las páginas deben estar entre 1 y 3000.';
        }
    }

    if (!isset($errores['genero']) && !in_array($valores['genero'], ['ciencia', 'fantasia', 'terror'], true)) {
        $errores['genero'] = 'Elige ciencia, fantasía o terror.';
    }

    $unidades = false;
    if (!isset($errores['unidades'])) {
        $unidades = filter_var($valores['unidades'], FILTER_VALIDATE_INT);
        if ($unidades === false) {
            $errores['unidades'] = 'Los ejemplares o licencias deben ser un número entero.';
        } elseif ($unidades < 1 || $unidades > 50) {
            $errores['unidades'] = 'Los ejemplares o licencias deben estar entre 1 y 50.';
        }
    }

    $fechaAlta = null;
    if (!isset($errores['fechaAlta']) && $valores['fechaAlta'] !== '') {
        try {
            $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $valores['fechaAlta']);
        } catch (ValueError) {
            $fecha = false;
        }
        if ($fecha === false || $fecha->format('Y-m-d') !== $valores['fechaAlta']) {
            $errores['fechaAlta'] = 'Indica una fecha válida con formato YYYY-MM-DD.';
        } else {
            $fechaAlta = $fecha;
        }
    }

    $destacado = false;
    if (array_key_exists('destacado', $_POST)) {
        if ($_POST['destacado'] === '1') {
            $destacado = true;
        } else {
            $errores['destacado'] = 'Valor de destacado no válido.';
        }
    }
    $valores['destacado'] = $destacado;

    if (!isset($errores['observaciones']) && mb_strlen($valores['observaciones'], 'UTF-8') > 300) {
        $errores['observaciones'] = 'Las observaciones admiten hasta 300 caracteres.';
    }

    if (!isset($errores['correo'])) {
        if ($valores['correo'] === '') {
            $errores['correo'] = 'El correo es obligatorio.';
        } elseif (filter_var($valores['correo'], FILTER_VALIDATE_EMAIL) === false) {
            $errores['correo'] = 'El correo no es válido.';
        }
    }

    if ($errores === []) {
        $libro = null;
        try {
            $clase = $valores['tipo'] === 'papel' ? LibroPapel::class : LibroDigital::class;
            $libro = new $clase(
                $valores['titulo'],
                $valores['autor'],
                $paginas,
                $valores['genero'],
                $unidades,
                $fechaAlta,
                $destacado,
                $valores['observaciones']
            );
        } catch (InvalidArgumentException $ex) {
            $errores['general'] = $ex->getMessage();
        }

        if ($libro !== null) {
            $servicio->agregar($libro);
            $ficha = $servicio->filas([$libro])[0];
            $filas = $servicio->filas($servicio->todos());
            $resumen = $servicio->resumen($servicio->todos());
        }
    }
}

require dirname(__DIR__) . '/vistas/alta.php';
