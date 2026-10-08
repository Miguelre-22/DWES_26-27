<?php

declare(strict_types=1);

// Entrada facilitada: la lectura de controles GET ya está resuelta.
require_once __DIR__ . '/../src/actividades.php';
require_once __DIR__ . '/../src/deportes.php';

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function entrada(string $clave, string $defecto = ''): string
{
    return isset($_GET[$clave]) && is_string($_GET[$clave]) ? $_GET[$clave] : $defecto;
}

$actividades = prepararActividades($actividades, $reservas);

$texto = entrada('q');
$categoria = entrada('categoria');
$conPlazas = entrada('disponibles') === '1';
$orden = entrada('orden', 'nombre');

if (!in_array($orden, ['nombre', 'libres'], true)) {
    $orden = 'nombre';
}

$categorias = obtenerCategorias($actividades);
$aviso = '';

if (!categoriaValida($categoria, $categorias)) {
    $aviso = 'La categoría seleccionada no es válida.';
    $categoria = '';
}

$visibles = ordenarActividades(
    filtrarActividades($actividades, $texto, $categoria, $conPlazas),
    $orden
);
$resumen = resumirActividades($visibles);
$etiquetas = generarEtiquetas($visibles, prefijo: 'Actividad: ');

$id = entrada('id');
$seleccionada = null;
$avisoFicha = '';

if ($id !== '') {
    if (preg_match('/\A[0-9]+\z/', $id) !== 1 || normalizarId($id) <= 0) {
        $avisoFicha = 'Indica un id entero positivo.';
    } else {
        $seleccionada = buscarPorId($actividades, $id);

        if ($seleccionada === null) {
            $avisoFicha = 'No existe la actividad con ese id.';
        }
    }
}

$reservasFicha = $seleccionada === null ? [] : array_filter(
    $reservas,
    fn(array $r): bool => $r['actividadId'] === $seleccionada['id']
);

$codigo = entrada('codigo');
$validacionCodigo = $codigo === '' ? null : codigoValido($codigo);

require __DIR__ . '/../template/vista.php';