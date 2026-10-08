<?php
    $titulo = "Dune";
    $autor = "Frank Herbert";
    $paginas = 412;

    // Concatenación
    echo $titulo . " — " . $autor . " (" . $paginas . " páginas)";

    echo "<br>";

    // Interpolación
    echo "$titulo — $autor ($paginas páginas)";
?>