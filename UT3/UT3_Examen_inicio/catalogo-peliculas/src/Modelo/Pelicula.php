<?php

declare(strict_types=1);

namespace App\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

final class Pelicula
{
    private ?string $cartel = null;

    public function __construct(
        private string $titulo,
        private string $director,
        private int $duracion,
        private string $genero,
        private ?DateTimeImmutable $fechaEstreno = null
    ) {
        $this->titulo = trim($titulo);
        $this->director = trim($director);

        if (
            $this->titulo === '' || mb_strlen($this->titulo, 'UTF-8') > 120
            || $this->director === '' || mb_strlen($this->director, 'UTF-8') > 100
            || $duracion < 1 || $duracion > 300
            || !in_array($genero, ['ciencia', 'fantasia', 'terror'], true)
        ) {
            throw new InvalidArgumentException('La ficha de la película no es válida.');
        }
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function director(): string
    {
        return $this->director;
    }

    public function duracion(): int
    {
        return $this->duracion;
    }

    public function genero(): string
    {
        return $this->genero;
    }

    public function fechaEstreno(): ?DateTimeImmutable
    {
        return $this->fechaEstreno;
    }

    public function cartel(): ?string
    {
        return $this->cartel;
    }

    public function cambiarCartel(?string $nombre): void
    {
        if (
            $nombre !== null
            && preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) !== 1
        ) {
            throw new InvalidArgumentException('Nombre de cartel no válido.');
        }

        $this->cartel = $nombre;
    }
}
