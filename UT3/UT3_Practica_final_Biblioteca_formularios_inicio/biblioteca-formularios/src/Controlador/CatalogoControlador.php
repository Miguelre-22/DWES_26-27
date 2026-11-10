<?php
declare(strict_types=1);
namespace App\Controlador;

use App\Servicio\Biblioteca;
use function App\Soporte\validarFiltros;

final class CatalogoControlador
{
    public function __construct(private Biblioteca $biblioteca) {}

    public function mostrar(): void
    {
        $biblioteca = $this->biblioteca;
        $filtros = ['q' => '', 'genero' => ''];
        $errores = [];
        $libros = [];
        // COMPLETAR 2. Validar $_GET y consultar solo si no hay errores.
        $resultado = validarFiltros($_GET);
        $filtros = $resultado['valores'];
        $errores = $resultado['errores'];
        if ($errores === []) {
            $libros = $biblioteca->filtrar($filtros['q'], $filtros['genero']);
        }

        require dirname(__DIR__, 2) . '/vistas/catalogo.php';
    }
}
