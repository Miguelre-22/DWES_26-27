<?php
declare(strict_types=1);
namespace App\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

final class Libro
{
    private ?string $portada = null;

    public function __construct(
        private string $titulo,
        private string $autor,
        private int $paginas,
        private string $genero,
        private ?DateTimeImmutable $fechaAlta = null
    ) {
        $this->titulo = trim($titulo);
        $this->autor = trim($autor);
        if ($this->titulo === '' || mb_strlen($this->titulo, 'UTF-8') > 120
            || $this->autor === '' || mb_strlen($this->autor, 'UTF-8') > 100
            || $paginas < 1 || $paginas > 3000
            || !in_array($genero, ['ciencia', 'fantasia', 'terror'], true)) {
            throw new InvalidArgumentException('La ficha del libro no es válida.');
        }
    }

    public function titulo(): string { return $this->titulo; }
    public function autor(): string { return $this->autor; }
    public function paginas(): int { return $this->paginas; }
    public function genero(): string { return $this->genero; }
    public function fechaAlta(): ?DateTimeImmutable { return $this->fechaAlta; }
    public function portada(): ?string { return $this->portada; }

    public function cambiarPortada(?string $nombre): void
    {
        if ($nombre !== null
            && preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) !== 1) {
            throw new InvalidArgumentException('Nombre de portada no válido.');
        }
        $this->portada = $nombre;
    }
}
