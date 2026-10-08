<?php
    $genero = $_GET['genero'] ?? 'todos';
    $mensaje = ($genero != 'todos') ? 'Filtro activo' : 'Sin filtro';
    echo ($mensaje);
?>
