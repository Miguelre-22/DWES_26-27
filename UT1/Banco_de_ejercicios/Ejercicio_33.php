<?php
    $busqueda = $_GET['q'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<body>
    <p>Buscando: ...<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8');?></p>
</body>
</html>
