<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Miguel\Biblioteca\Servicio\BibliotecaService;

$libros = require dirname(__DIR__) . '/datos/libros.php';
$servicio = new BibliotecaService($libros);

$q = $_GET['q'] ?? '';
$genero = $_GET['genero'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$q = is_string($q) ? $q : '';
$genero = is_string($genero) ? $genero : '';
$tipo = is_string($tipo) ? $tipo : '';
$soloDestacados = array_key_exists('destacados', $_GET);

$librosFiltrados = $servicio->filtrar($q, $genero, $tipo, $soloDestacados);

$filas = $servicio->filas($librosFiltrados);
$resumen = $servicio->resumen($librosFiltrados);

require dirname(__DIR__) . '/vistas/catalogo.php';
