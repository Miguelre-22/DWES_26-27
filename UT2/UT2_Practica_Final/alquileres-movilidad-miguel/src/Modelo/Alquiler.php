<?php

declare(strict_types=1);

namespace Clase\Alquileres\Modelo;

use Clase\Alquileres\Exception\AlquilerException;
use InvalidArgumentException;

abstract class Alquiler
{
    // Mejor promoción
    public function __construct(private readonly int $id, private string $cliente, private int $dias, private EstadoAlquiler $estado)
    {
        $cliente = trim($cliente);

        if ($id <= 0) {
            throw new InvalidArgumentException('El id tiene que ser un número positivo.');
        }

        if ($cliente === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }

        if ($dias < 1 || $dias > 7) {
            throw new InvalidArgumentException('La duración está fuera del rango permitido.');
        }
        $this->cliente = $cliente;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function cliente(): string
    {
        return $this->cliente;
    }

    public function dias(): int
    {
        return $this->dias;
    }

    public function estado(): EstadoAlquiler
    {
        return $this->estado;
    }

    public abstract function modalidad(): string;

    protected abstract function tarifaDiaria(): int;

    public function importe(): int
    {
        return $this->dias * $this->tarifaDiaria();
    }

    public function iniciar(): void
    {
        if ($this->estado !== EstadoAlquiler::Reservado) {
            throw new AlquilerException('El cambio no se ha realizado ya que el valor de estado no es reservado.');
        }
        $this->estado = EstadoAlquiler::Activo;
    }

    public function finalizar(): void
    {
        if ($this->estado !== EstadoAlquiler::Activo) {
            throw new AlquilerException('El cambio no se ha realizado ya que el valor de estado no es activo.');
        }
        $this->estado = EstadoAlquiler::Finalizado;
    }
}
