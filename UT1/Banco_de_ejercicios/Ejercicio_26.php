<?php
    declare(strict_types=1);

    function esLargo(int $paginas): bool
    {
        return $paginas > 500;
    }

    echo esLargo(600) ? "true" : "false";

    // Si se invoca con la cadena "600", dará un error ya que la función espera un valor de tipo entero, no una cadena.
?>