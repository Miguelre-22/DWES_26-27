<?php
declare(strict_types=1);
namespace App\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

final class Material
{
    private ?string $imagen = null;

    public function __construct(
        private string $nombre,
        private string $fabricante,
        private int $unidades,
        private string $categoria,
        private ?DateTimeImmutable $fechaAlta = null
    ) {
        $this->nombre = trim($nombre);
        $this->fabricante = trim($fabricante);
        if ($this->nombre === '' || mb_strlen($this->nombre, 'UTF-8') > 120
            || $this->fabricante === '' || mb_strlen($this->fabricante, 'UTF-8') > 100
            || $unidades < 1 || $unidades > 3000
            || !in_array($categoria, ['colectivo', 'raqueta', 'fitness'], true)) {
            throw new InvalidArgumentException('La ficha del material no es válida.');
        }
    }

    public function nombre(): string { return $this->nombre; }
    public function fabricante(): string { return $this->fabricante; }
    public function unidades(): int { return $this->unidades; }
    public function categoria(): string { return $this->categoria; }
    public function fechaAlta(): ?DateTimeImmutable { return $this->fechaAlta; }
    public function imagen(): ?string { return $this->imagen; }

    public function cambiarImagen(?string $nombre): void
    {
        if ($nombre !== null
            && preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) !== 1) {
            throw new InvalidArgumentException('Nombre de imagen no válido.');
        }
        $this->imagen = $nombre;
    }
}
