<?php
    $texto = "PHP";
    $i = 0;

    while ($i < strlen($texto)) {
        if ($i === 1) {
            echo "-";
        }

        echo $texto[$i];
        $i++;
    }

    // Se imprime "P-HP" y el cuerpo del bucle while se ejecuta 3 veces.
?>