<?php

declare(strict_types=1);

namespace Miguel\Biblioteca\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

abstract class Libro
{
    private const GENEROS = ['ciencia', 'fantasia', 'terror'];

    public function __construct(
        private string $titulo,
        private string $autor,
        private int $paginas,
        private string $genero,
        private int $unidades,
        private ?DateTimeImmutable $fechaAlta,
        private bool $destacado,
        private string $observaciones
    ) {
        $this->titulo = trim($this->titulo);
        $this->autor = trim($this->autor);
        $this->genero = trim($this->genero);
        $this->observaciones = trim($this->observaciones);

        if ($this->titulo === '' || mb_strlen($this->titulo, 'UTF-8') > 120) {
            throw new InvalidArgumentException('El título es obligatorio y admite hasta 120 caracteres.');
        }

        if ($this->autor === '' || mb_strlen($this->autor, 'UTF-8') > 100) {
            throw new InvalidArgumentException('El autor es obligatorio y admite hasta 100 caracteres.');
        }

        if ($this->paginas < 1 || $this->paginas > 3000) {
            throw new InvalidArgumentException('Las páginas deben estar entre 1 y 3000.');
        }

        if (!in_array($this->genero, self::GENEROS, true)) {
            throw new InvalidArgumentException('El género debe ser ciencia, fantasia o terror.');
        }

        if ($this->unidades < 1 || $this->unidades > 50) {
            throw new InvalidArgumentException('Las unidades deben estar entre 1 y 50.');
        }

        if (mb_strlen($this->observaciones, 'UTF-8') > 300) {
            throw new InvalidArgumentException('Las observaciones admiten hasta 300 caracteres.');
        }
    }

    public function titulo(): string { return $this->titulo; }
    public function autor(): string { return $this->autor; }
    public function paginas(): int { return $this->paginas; }
    public function genero(): string { return $this->genero; }
    public function unidades(): int { return $this->unidades; }
    public function fechaAlta(): ?DateTimeImmutable { return $this->fechaAlta; }
    public function destacado(): bool { return $this->destacado; }
    public function observaciones(): string { return $this->observaciones; }

    abstract public function getTipo(): string;
    abstract public function costeReposicionCentimos(): int;
}
