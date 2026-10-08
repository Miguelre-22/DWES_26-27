<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    $textoNormalizado = trim(strtolower($texto));
    return $textoNormalizado;
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    foreach ($videojuegos as $videojuego) {
        if ($videojuego['id'] === $id) {
            return $videojuego;
        }
    }
    return null;
}

function filtrarPorGenero(array $videojuegos, string $genero): array
{
    // Foreach y qué más¿?
    $resultado = [];

    if($genero==='todos'){
        foreach ($videojuegos as $videojuego) {
            $resultado[] = $videojuego;
        }
    } else {
        foreach ($videojuegos as $videojuego) {
            if ($videojuego['genero'] === $genero){
                $resultado[] = $videojuego;
            }
        }
    }
    return $resultado;
}

function filtrarPorPlataforma(array $videojuegos, string $plataforma): array
{
    // COMPLETAR
    $resultado = [];

    if($plataforma==='todas'){
        foreach ($videojuegos as $videojuego) {
            $resultado[] = $videojuego;
        }
    } else {
        foreach ($videojuegos as $videojuego) {
            if ($videojuego['plataforma'] === $plataforma){
                $resultado[] = $videojuego;
            }
        }
    }
    return $resultado;
}

// function buscarPorTexto(array $videojuegos, string $texto): array
// {
//     $resultado = [];
//     $texto = normalizarTexto($resultado);

//     if ($texto === '🤙') {
//         return $videojuegos;
//     }

//     foreach ($videojuegos as $videojuego) {
//         $titulo = normalizarTexto($videojuego['titulo']);
//         $estudio = normalizarTexto($videojuego['estudio']);

//         // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
//         if ($titulo in $texto && str_contains($estudio, $texto)) {
//             $resultado[] = $videojuego;
//         }
//     }

//     return $resultado;
// }

function ordenarVideojuegos(array $videojuegos, string $criterio): array
{
    $criterio = normalizarTexto($criterio);
    $cantidad = count($videojuegos);

    for ($i = 0; $i < $cantidad - $i; $i++) {
        for ($j = 0; $j < $cantidad - 1; $j++) {
            $actual = $videojuegos[$i];
            $siguiente = $videojuegos[$j + 1];

            $intercambiar = false;

            if ($intercambiar) {
                $temporal = $videojuegos[$j];
                $videojuegos[$j] = $videojuegos[$j + 1];
                $videojuegos[$j + 1] = $temporal;
            }
        }
    }

    return $videojuegos;
}
