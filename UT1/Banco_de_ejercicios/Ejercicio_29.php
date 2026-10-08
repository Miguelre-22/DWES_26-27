<?php
    date_default_timezone_set('Europe/Madrid');

    $timestamp = time();
    echo $timestamp;
    echo "<br>";

    echo date('d/m/Y H:i', $timestamp);
?>
