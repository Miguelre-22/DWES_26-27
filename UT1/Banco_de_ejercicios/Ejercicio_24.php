<?php
    //declare(strict_types=1);

    // $contador = 0;
    // function incrementar() {
    //     $contador++;
    // }
    // incrementar();
    // echo $contador;

    // El programa no funcina porque $contador dentro de la función es una variable local y no modifica el $contador externo.

    $contador = 0;
    function incrementar(int &$contador) {
        return $contador++;
    }
    incrementar($contador);
    echo $contador;
?>