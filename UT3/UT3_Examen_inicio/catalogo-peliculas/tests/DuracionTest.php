<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarPelicula;

final class DuracionTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de las cinco duraciones.


    // Proporcionado. Datos válidos sobre los que varías solo duracion.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Dune',
            'director' => 'Denis Villeneuve',
            'duracion' => '155',
            'genero' => 'ciencia',
            'fechaEstreno' => '',
        ];
        
    }
}
