<?php
    function calcularMulta(int $dias, float $precioDia): float
    {
        return $dias * $precioDia;
    }

    echo calcularMulta(5, 2.50);
?>