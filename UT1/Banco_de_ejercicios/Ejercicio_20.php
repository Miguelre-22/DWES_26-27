<?php
    $numeroPaginas = [115, 448, 759, 90, 671, 333, 422, 961];

    sort($numeroPaginas);

    $suma = 0;
    echo "Páginas ordenadas de menor a mayor: ";
    foreach ($numeroPaginas as $pagina) {
        $suma += $pagina;
        echo "$pagina" . "| ";
    }

    $total_libros = count($numeroPaginas);
    $minimo = $numeroPaginas[0];
    $maximo = $numeroPaginas[$total_libros - 1];
    $media = $suma / $total_libros;

    echo "<br>";
    echo "Número mínimo de páginas: " . $minimo . "<br>";
    echo "Número máximo de páginas: " . $maximo . "<br>";
    echo "Media de páginas: " . $media;
?>
