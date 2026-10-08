<?php
    $inicio = new DateTimeImmutable('2026-09-01');
    $fin = new DateTimeImmutable('2026-09-18');

    $diferencia = $inicio->diff($fin);

    echo $diferencia->days;
?>
