<?php
declare(strict_types=1);
namespace App\Model;
use DateTimeImmutable;
use InvalidArgumentException;
final class Libro
{
    private string $titulo;
    private string $autor;
    private int $paginas;
    private string $genero;
    private ?DateTimeImmutable $fechaAlta;
    private bool $disponible = true;
    private ?string $portada = null;

    public function __construct(string $titulo, string $autor,
        int $paginas, string $genero = 'ciencia',
        ?DateTimeImmutable $fechaAlta = null)
    {
        $this->actualizarDatos($titulo, $autor, $paginas,
            $genero, $fechaAlta);
    }

    public function actualizarDatos(string $titulo, string $autor,
        int $paginas, string $genero,
        ?DateTimeImmutable $fechaAlta): void
    {
        $titulo = trim($titulo);
        $autor = trim($autor);
        if ($titulo === '' || mb_strlen($titulo, 'UTF-8') > 120
            || $autor === '' || $paginas < 1 || $paginas > 3000
            || !in_array($genero, ['ciencia', 'fantasia', 'terror'],
                true)) {
            throw new InvalidArgumentException('Ficha no válida.');
        }
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->paginas = $paginas;
        $this->genero = $genero;
        $this->fechaAlta = $fechaAlta;
    }

    public function titulo(): string { return $this->titulo; }
    public function autor(): string { return $this->autor; }
    public function paginas(): int { return $this->paginas; }
    public function genero(): string { return $this->genero; }
    public function fechaAlta(): ?DateTimeImmutable
    { return $this->fechaAlta; }
    public function estaDisponible(): bool
    { return $this->disponible; }
    public function portada(): ?string { return $this->portada; }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException('Ya está prestado.');
        }
        $this->disponible = false;
    }
    public function devolver(): void { $this->disponible = true; }
    public function cambiarPortada(?string $nombre): void
    {
        if ($nombre !== null && preg_match(
            '/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) !== 1) {
            throw new InvalidArgumentException('Nombre no válido.');
        }
        $this->portada = $nombre;
    }
}
