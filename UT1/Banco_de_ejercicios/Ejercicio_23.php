<?php
    //declare(strict_types=1);

    function calcularFechaPrestamo($dias = 15) {
        return $dias;
    }

    echo "Llamada sin argumento: " . calcularFechaPrestamo();
    echo "<br>";
    echo "Llamada con argumento: " . calcularFechaPrestamo(22);
?>