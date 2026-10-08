<?php $titulos = ['Don Quijote de la Mancha', 'El retrato de Dorian Gray', 'Ana Karenina', 'El Principito'];?>
<ul>
    <?php foreach ($titulos as $titulo): ?>
        <li>
            <?= htmlspecialchars($titulo) ?>
        </li>
    <?php endforeach; ?>
</ul>
