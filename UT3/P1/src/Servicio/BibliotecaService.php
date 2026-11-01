<?php

declare(strict_types=1);

namespace Miguel\Biblioteca\Servicio;

use Miguel\Biblioteca\Modelo\Libro;

class BibliotecaService
{
    private array $libros;

    public function __construct(array $libros)
    {
        $this->libros = $libros;
    }

    public function todos(): array
    {
        return $this->libros;
    }

    public function agregar(Libro $libro): void
    {
        $this->libros[] = $libro;
    }

    public function filtrar(
        string $q,
        string $genero,
        string $tipo,
        bool $soloDestacados
    ): array {
        $texto = mb_strtolower(trim($q), 'UTF-8');

        $resultado = array_filter(
            $this->libros,
            fn(Libro $l): bool =>
                ($texto === ''
                    || str_contains(mb_strtolower($l->titulo(), 'UTF-8'), $texto)
                    || str_contains(mb_strtolower($l->autor(), 'UTF-8'), $texto))
                && ($genero === '' || $l->genero() === $genero)
                && ($tipo === '' || $l->getTipo() === $tipo)
                && (!$soloDestacados || $l->destacado())
        );

        return array_values($resultado);
    }

    public function filas(array $libros): array
    {
        return array_map(
            fn(Libro $l): array => [
                'titulo' => $l->titulo(),
                'autor' => $l->autor(),
                'paginas' => $l->paginas(),
                'genero' => $l->genero(),
                'tipo' => $l->getTipo(),
                'unidades' => $l->unidades(),
                'fechaAlta' => $l->fechaAlta()?->format('Y-m-d') ?? 'Sin fecha',
                'destacado' => $l->destacado(),
                'observaciones' => $l->observaciones(),
                'costeCentimos' => $l->costeReposicionCentimos(),
            ],
            $libros
        );
    }

    public function resumen(array $libros): array
    {
        return array_reduce(
            $libros,
            fn(array $acc, Libro $l): array => [
                'titulos' => $acc['titulos'] + 1,
                'unidades' => $acc['unidades'] + $l->unidades(),
                'paginas' => $acc['paginas'] + $l->paginas(),
                'costeCentimos' => $acc['costeCentimos'] + $l->costeReposicionCentimos(),
            ],
            ['titulos' => 0, 'unidades' => 0, 'paginas' => 0, 'costeCentimos' => 0]
        );
    }
}
