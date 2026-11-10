<?php
declare(strict_types=1);
namespace App\Controlador;

use App\Servicio\Biblioteca;
use App\Modelo\Libro;
use InvalidArgumentException;
use RuntimeException;
use function App\Soporte\validarLibro;
use function App\Soporte\postExcesivo;
use function App\Soporte\inspeccionarPortada;
use function App\Soporte\prepararDestino;

final class AltaControlador
{
    public function __construct(private Biblioteca $biblioteca) {}

    public function mostrar(): void
    {
        $biblioteca = $this->biblioteca;
        $errores = [];
        $creado = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (postExcesivo()) {
                $errores['general'] = 'El envío completo supera el límite de PHP.';
            } else {
                // Proporcionado. Valida campos y portada antes de crear o mover.
                $resultado = validarLibro($_POST);
                $errores = $resultado['errores'];
                $subida = inspeccionarPortada($_FILES);
                if ($subida['error'] !== null) { $errores['portada'] = $subida['error']; }
                if ($errores === []) {
                    $datos = $resultado['datos'];
                    try {
                        // COMPLETAR 5. Construir $nuevo con los cinco datos validados.
                        $nuevo = new Libro(
                            $datos['titulo'],
                            $datos['autor'],
                            $datos['paginas'],
                            $datos['genero'],
                            $datos['fechaAlta']
                        );

                        // COMPLETAR 7. Guardar y asociar la portada si hay archivo.
                        if ($subida['archivo'] !== null) {
                            $archivo = $subida['archivo'];
                            $destino = prepararDestino($archivo['extension']);
                            if (move_uploaded_file($archivo['tmp_name'], $destino['ruta'])) {
                                $nuevo->cambiarPortada($destino['nombre']);
                            } else {
                                $errores['portada'] = 'No se ha podido guardar la portada.';
                            }
                        }

                        // Al terminar sin errores, agregar $nuevo y asignarlo a $creado.
                        if ($errores === []) {
                            $biblioteca->agregar($nuevo);
                            $creado = $nuevo;
                        }
                        
                    } catch (InvalidArgumentException) {
                        $errores['general'] = 'No se ha podido crear el libro con esos datos.';
                    } catch (RuntimeException $error) {
                        $errores['portada'] = $error->getMessage();
                    }
                }
            }
        }
        require dirname(__DIR__, 2) . '/vistas/alta.php';
    }
}
