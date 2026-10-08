<?php
    function duplicarValor(int $n) {
        $n *= 2;
    }
    function duplicarReferencia(int &$n) {
        $n *= 2;
    }
    $a = 5;
    $b = 5;
    duplicarValor($a);
    duplicarReferencia($b);
    echo "$a - $b";

    // La salida será 5 - 10. $a queda en 5 porque se pasa por valor (copia), 
    // mientras $b queda en 10 porque se pasa por referencia (&) y se modifica la variable original.
?>