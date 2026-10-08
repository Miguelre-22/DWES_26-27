<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../src/datos.php';

    function calcularMediaPaginas(array $catalogo): float{
        $suma = 0;
        foreach($catalogo as $libro){
            $numPaginas = $libro['paginas'];
            $suma += $numPaginas;
        }
        return $suma /  count($catalogo);
    }

    function obtenerPorId(array $catalogo, int $id): ? array{
        foreach($catalogo as $libro){
            if($libro['id'] === $id){
                return $libro;
            }
        }
        return null;
    }

    function obtenerPorGenero(array $catalogo, string $genero): ? array{
        $añadir = [];
        foreach($catalogo as $libro){
            if($libro['genero'] === $genero){
                $añadir[]=$libro;
            }
        }
        return $añadir;
    }

    function obtenerPorDisponibilidad(array $catalogo, bool $disponibilidad): ? array{
        $añadir = [];
        foreach($catalogo as $libro){
            if($libro['disponibilidad'] === $disponibilidad){
                $añadir[]=$libro;
            }
        }
        return $añadir;
    }
?>