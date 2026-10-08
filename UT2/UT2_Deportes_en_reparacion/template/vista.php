<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Actividades y reservas deportivas</title>
    <link rel="stylesheet" href="/estilos.css">
</head>

<body>
    <main>
        <header>
            <p class="eyebrow">DWES · UT2 01 · PHP avanzado</p>
            <h1>Actividades y reservas deportivas</h1>
            <p>Consulta las actividades del centro deportivo y las plazas de sus reservas.</p>
        </header>

        <form class="filters" method="get">
            <label>
                Buscar actividad
                <input name="q" value="<?= e($texto) ?>" placeholder="Prueba PÁDEL u ÓRBITA">
            </label>
            <label>
                Categoría
                <select name="categoria">
                    <option value="">Todas</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= e($cat) ?>" <?= $categoria === $cat ? 'selected' : '' ?>>
                            <?= e($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                Orden
                <select name="orden">
                    <option value="nombre" <?= $orden === 'nombre' ? 'selected' : '' ?>>
                        Nombre A–Z
                    </option>
                    <option value="libres" <?= $orden === 'libres' ? 'selected' : '' ?>>
                        Plazas libres de menor a mayor
                    </option>
                </select>
            </label>
            <label class="checkbox">
                <input type="checkbox" name="disponibles" value="1" <?= $conPlazas ? 'checked' : '' ?>>
                Solo con plazas
            </label>
            <button>Consultar</button>
            <a href="/">Reiniciar</a>
        </form>

        <?php if ($aviso !== ''): ?>
            <p class="notice" role="status"><?= e($aviso) ?></p>
        <?php endif; ?>

        <section class="metrics" aria-label="Resumen del listado">
            <div>
                <strong><?= $resumen['cantidad'] ?></strong>
                <span>actividades</span>
            </div>
            <div>
                <strong><?= $resumen['capacidad'] ?></strong>
                <span>plazas de capacidad</span>
            </div>
            <div>
                <strong><?= $resumen['ocupadas'] ?></strong>
                <span>plazas ocupadas</span>
            </div>
            <div>
                <strong><?= $resumen['libres'] ?></strong>
                <span>plazas libres</span>
            </div>
        </section>

        <p class="checks">
            ¿Hay alguna completa? <strong><?= $resumen['hayCompletas'] ? 'Sí' : 'No' ?></strong> ·
            ¿Todas tienen plazas? <strong><?= $resumen['todasConPlazas'] ? 'Sí' : 'No' ?></strong>
        </p>

        <?php if ($visibles === []): ?>
            <p class="empty">No hay actividades que coincidan con la consulta.</p>
        <?php endif; ?>

        <section class="activities" aria-label="Actividades">
            <?php foreach ($visibles as $a): ?>
                <article class="activity" data-id="<?= $a['id'] ?>">
                    <p class="category"><?= e($a['categoria']) ?></p>
                    <h2><?= e(limpiarEspacios($a['nombre'])) ?></h2>
                    <p><?= e(monitorVisible($a['monitor'])) ?></p>
                    <p><?= $a['minutos'] ?> minutos · <?= e($a['codigo']) ?></p>
                    <p>
                        Inicio del nombre:
                        <span class="inicio"><?= e(inicioNombre($a['nombre'])) ?></span>
                    </p>
                    <p class="stock">
                        <?= $a['ocupadas'] ?> ocupadas · <?= $a['libres'] ?> libres de <?= $a['capacidad'] ?>
                    </p>
                    <a href="/?id=<?= $a['id'] ?>">Ver actividad <?= $a['id'] ?> y sus reservas</a>
                </article>
            <?php endforeach; ?>
        </section>

        <section class="panel">
            <h2>Consulta de actividad por id</h2>
            <p>La ficha se busca entre todas las actividades, independientemente de los filtros.</p>
            <form method="get" class="filters">
                <label>
                    Id de actividad
                    <input name="id" value="<?= e($id) ?>" placeholder="Prueba 101 o 999">
                </label>
                <button>Ver ficha</button>
            </form>

            <?php if ($seleccionada !== null): ?>
                <article class="ficha">
                    <h3><?= e(limpiarEspacios($seleccionada['nombre'])) ?></h3>
                    <p>
                        <?= e(monitorVisible($seleccionada['monitor'])) ?> ·
                        <?= $seleccionada['libres'] ?> plazas libres
                    </p>
                    <table>
                        <caption>Reservas precargadas de esta actividad</caption>
                        <thead>
                            <tr>
                                <th>Reserva</th>
                                <th>Plazas</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservasFicha as $r): ?>
                                <tr>
                                    <td><?= $r['id'] ?></td>
                                    <td><?= $r['plazas'] ?></td>
                                    <td><?= e($r['estado']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p>Solo las reservas confirmadas ocupan plazas.</p>
                </article>
            <?php endif; ?>

            <?php if ($avisoFicha !== ''): ?>
                <p class="notice" role="status"><?= e($avisoFicha) ?></p>
            <?php endif; ?>
        </section>

        <section class="panel">
            <h2>Comprobación de códigos de actividad</h2>
            <form class="filters" method="get">
                <label>
                    Código
                    <input name="codigo" value="<?= e($codigo) ?>" placeholder="DEP-2026-0101">
                </label>
                <button>Comprobar</button>
            </form>

            <?php if ($validacionCodigo !== null): ?>
                <p class="resultado-codigo" role="status">
                    <?= $validacionCodigo ? 'Código válido' : 'Código no válido' ?>
                </p>
            <?php endif; ?>
        </section>

        <details>
            <summary>Etiquetas del listado</summary>
            <ul>
                <?php foreach ($etiquetas as $etiqueta): ?>
                    <li><?= e($etiqueta) ?></li>
                <?php endforeach; ?>
            </ul>
        </details>

        <footer>Prototipo local · Actividades y reservas en arrays · PHP 8.5</footer>
    </main>
</body>

</html>