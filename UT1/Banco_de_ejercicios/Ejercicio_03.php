<?php
    $precio = 24.90;

    // Descuento del 15%
    $precio *= 0.85;
    $precioDescontado = $precio;

    // IVA del 4%
    $iva = $precio * 0.04;
    $precioFinal = $precio + $iva;

    echo "Precio descontado: " . ($precioDescontado) . " €<br>";
    echo "IVA: " . ($iva) . " €<br>";
    echo "Precio final: " . ($precioFinal) . " €";
?>
