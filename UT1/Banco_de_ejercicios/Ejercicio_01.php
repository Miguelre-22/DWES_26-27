<?php
    $titulo = "El Quijote"; 
    $autor = "Miguel de Cervantes"; 
    $paginas = 863; 
    $precio = 19.95; 
    $disponible = true; 
    echo "El libro $titulo, escrito por $autor, tiene $paginas páginas, cuesta $precio
          € y está disponible: " . ($disponible ? "Sí" : "No") . ".";
?>