<?php
    date_default_timezone_set('Europe/Madrid');

    $momentoActual = new DateTimeImmutable();
    echo $momentoActual->format('d/m/Y H:i');

    echo "<br>";

    $devolucion = $momentoActual->modify('+15 days');
    echo $devolucion->format('d/m/Y H:i');
?>
