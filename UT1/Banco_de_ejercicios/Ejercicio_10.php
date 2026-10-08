<?php
    $dias = 5;

    if ($dias == 0) {
        echo "Sin retraso";
    } elseif ($dias >= 1 && $dias <= 7) {
        echo "Retraso leve";
    } elseif ($dias >= 8 && $dias <= 30) {
        echo "Retraso grave";
    } else {
        echo "Bloqueo temporal";
    }
?>