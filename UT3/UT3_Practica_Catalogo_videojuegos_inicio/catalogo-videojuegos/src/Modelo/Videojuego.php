<?php

declare(strict_types=1);

namespace App\Modelo;

use DateTimeImmutable;
use InvalidArgumentException;

final class Videojuego
{
    private ?string $caratula = null;

    public function __construct(
        private string $titulo,
        private string $estudio,
        private int $horas,
        private string $genero,
        private ?DateTimeImmutable $fechaLanzamiento = null
    ) {
        $this->titulo = trim($titulo);
        $this->estudio = trim($estudio);

        if (
            $this->titulo === '' || mb_strlen($this->titulo, 'UTF-8') > 120
            || $this->estudio === '' || mb_strlen($this->estudio, 'UTF-8') > 100
            || $horas < 1 || $horas > 300
            || !in_array($genero, ['aventura', 'estrategia', 'rol'], true)
        ) {
            throw new InvalidArgumentException('La ficha del videojuego no es válida.');
        }
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function estudio(): string
    {
        return $this->estudio;
    }

    public function horas(): int
    {
        return $this->horas;
    }

    public function genero(): string
    {
        return $this->genero;
    }

    public function fechaLanzamiento(): ?DateTimeImmutable
    {
        return $this->fechaLanzamiento;
    }

    public function caratula(): ?string
    {
        return $this->caratula;
    }

    public function cambiarCaratula(?string $nombre): void
    {
        if (
            $nombre !== null
            && preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) !== 1
        ) {
            throw new InvalidArgumentException('Nombre de caratula no válido.');
        }

        $this->caratula = $nombre;
    }
}
