<?php
declare(strict_types=1);
namespace App\Controlador;

use App\Servicio\Inventario;
use function App\Soporte\validarFiltros;

final class CatalogoControlador
{
    public function __construct(private Inventario $inventario) {}

    public function mostrar(): void
    {
        $inventario = $this->inventario;
        $filtros = ['q' => '', 'categoria' => ''];
        $errores = [];
        $materiales = [];
        // COMPLETAR 2. Validar $_GET y consultar solo si no hay errores.
        $resultado = validarFiltros($_GET);
        $filtros = $resultado['valores'];
        $errores = $resultado['errores'];

        if ($errores === []) {
            $materiales = $inventario->filtrar($filtros['q'], $filtros['categoria']);
        }
        require dirname(__DIR__, 2) . '/vistas/catalogo.php';
    }
}
