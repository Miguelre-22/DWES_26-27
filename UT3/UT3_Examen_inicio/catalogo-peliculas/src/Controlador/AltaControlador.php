<?php

declare(strict_types=1);

namespace App\Controlador;

use App\Servicio\Catalogo;
use App\Modelo\Pelicula;
use InvalidArgumentException;
use RuntimeException;

use function App\Soporte\validarPelicula;
use function App\Soporte\postExcesivo;
use function App\Soporte\inspeccionarCartel;
use function App\Soporte\prepararDestino;

final class AltaControlador
{
    public function __construct(private Catalogo $catalogo)
    {
    }

    public function mostrar(): void
    {
        $catalogo = $this->catalogo;
        $errores = [];
        $creado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (postExcesivo()) {
                $errores['general'] = 'El envío completo supera el límite de PHP.';
            } else {
                // Proporcionado. Valida campos y cartel antes de crear o mover.
                $resultado = validarPelicula($_POST);
                $errores = $resultado['errores'];
                $subida = inspeccionarCartel($_FILES);

                if ($subida['error'] !== null) {
                    $errores['cartel'] = $subida['error'];
                }

                if ($errores === []) {
                    $datos = $resultado['datos'];

                    try {
                        // COMPLETAR 3. Construir $nuevo con los cinco datos validados.
                        $nuevo = new Pelicula(
                            $datos['titulo'],
                            $datos['director'],
                            $datos['duracion'],
                            $datos['genero'],
                            $datos['fechaEstreno']
                        );
                        // COMPLETAR 5. Guardar y asociar el cartel si hay archivo.
                        if ($subida["archivo"] !== null) {
                            $archivo = $subida["archivo"];
                            $destino = prepararDestino($archivo["extension"]);

                            if (move_uploaded_file($archivo["tmp_name"], $destino["ruta"]) === false) {
                                $errores["cartel"] = 'No se ha podido subir.';
                            } else {
                                $nuevo->cambiarCartel($destino['nombre']);
                            }
                        }
                        // Al terminar sin errores, agregar $nuevo y asignarlo a $creado.
                        if ($errores === []) {
                            $catalogo->agregar($nuevo);
                            $creado = $nuevo;
                        }

                    } catch (InvalidArgumentException) {
                        $errores['general'] = 'No se ha podido crear la película con esos datos.';
                    } catch (RuntimeException $error) {
                        $errores['cartel'] = $error->getMessage();
                    }
                }
            }
        }

        require dirname(__DIR__, 2) . '/vistas/alta.php';
    }
}
