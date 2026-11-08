<?php
declare(strict_types=1);
namespace App\Controlador;

use App\Servicio\Inventario;
use App\Modelo\Material;
use InvalidArgumentException;
use RuntimeException;
use function App\Soporte\validarMaterial;
use function App\Soporte\postExcesivo;
use function App\Soporte\inspeccionarImagen;
use function App\Soporte\prepararDestino;

final class AltaControlador
{
    public function __construct(private Inventario $inventario) {}

    public function mostrar(): void
    {
        $inventario = $this->inventario;
        $errores = [];
        $creado = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (postExcesivo()) {
                $errores['general'] = 'El envío completo supera el límite de PHP.';
            } else {
                // Proporcionado. Valida campos y imagen antes de crear o mover.
                $resultado = validarMaterial($_POST);
                $errores = $resultado['errores'];
                $subida = inspeccionarImagen($_FILES);
                if ($subida['error'] !== null) { $errores['imagen'] = $subida['error']; }
                if ($errores === []) {
                    $datos = $resultado['datos'];
                    try {
                        // COMPLETAR 5. Construir $nuevo con los cinco datos validados.
                        $nuevo = new Material(
                            $datos['nombre'],
                            $datos['fabricante'],
                            $datos['unidades'],
                            $datos['categoria'],
                            $datos['fechaAlta']
                        );
                        // COMPLETAR 7. Guardar y asociar la imagen si hay archivo.
                        if ($subida['archivo'] !== null) {
                            $archivo = $subida['archivo'];
                            $destino = prepararDestino($archivo['extension']);

                            if (move_uploaded_file($archivo['tmp_name'], $destino['ruta'])) {
                                $nuevo->cambiarImagen($destino['nombre']);
                            } else {
                                $errores['imagen'] = 'No se ha podido guardar la imagen.';
                            }
                        }
                        // Al terminar sin errores, agregar $nuevo y asignarlo a $creado.
                        if ($errores === []) {
                            $inventario->agregar($nuevo);
                            $creado = $nuevo;
                        }
                    } catch (InvalidArgumentException) {
                        $errores['general'] = 'No se ha podido crear el material con esos datos.';
                    } catch (RuntimeException $error) {
                        $errores['imagen'] = $error->getMessage();
                    }
                }
            }
        }
        require dirname(__DIR__, 2) . '/vistas/alta.php';
    }
}
