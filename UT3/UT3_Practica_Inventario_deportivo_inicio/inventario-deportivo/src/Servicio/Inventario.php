<?php
declare(strict_types=1);
namespace App\Servicio;

use App\Modelo\Material;

final class Inventario
{
    public function __construct(private array $materiales) {}

    public function agregar(Material $material): void { $this->materiales[] = $material; }
    public function todos(): array { return $this->materiales; }

    public function filtrar(string $q, string $categoria): array
    {
        return array_values(array_filter($this->materiales,
            static function (Material $material) use ($q, $categoria): bool {
                $textoCoincide = $q === ''
                    || mb_stripos($material->nombre(), $q, 0, 'UTF-8') !== false
                    || mb_stripos($material->fabricante(), $q, 0, 'UTF-8') !== false;
                return $textoCoincide
                    && ($categoria === '' || $material->categoria() === $categoria);
            }));
    }
}
