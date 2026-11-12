<?php

declare(strict_types=1);

namespace Escuela\Curso\Compartido;

trait GeneraEtiqueta
{
    public function etiqueta(string $prefijo = ''): string
    {
        // TODO T1: construye la etiqueta consultando id() y nombre().
        return $prefijo . $this->id() . ' · ' . $this->nombre();
    }
}
