<?php

declare(strict_types=1);

namespace App\Controlador;

use App\Servicio\Catalogo;

use function App\Soporte\validarFiltros;

final class CatalogoControlador
{
    public function __construct(private Catalogo $catalogo)
    {
    }

    public function mostrar(): void
    {
        $catalogo = $this->catalogo;
        $filtros = ['q' => '', 'genero' => ''];
        $errores = [];
        $peliculas = [];

        // Proporcionado. Validación de filtros y consulta de la colección.
        $resultado = validarFiltros($_GET);
        $filtros = $resultado['valores'];
        $errores = $resultado['errores'];

        if ($errores === []) {
            $peliculas = $catalogo->filtrar($filtros['q'], $filtros['genero']);
        }

        require dirname(__DIR__, 2) . '/vistas/catalogo.php';
    }
}
