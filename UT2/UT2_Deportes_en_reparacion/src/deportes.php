<?php

declare(strict_types=1);

$actividades = [
    [
        'id' => 101,
        'nombre' => 'Pádel iniciación',
        'categoria' => 'Raqueta',
        'capacidad' => 8,
        'minutos' => 60,
        'monitor' => 'Ana Torres',
        'codigo' => 'DEP-2026-0101',
    ],
    [
        'id' => 102,
        'nombre' => 'Natación técnica',
        'categoria' => 'Acuáticas',
        'capacidad' => 6,
        'minutos' => 45,
        'monitor' => null,
        'codigo' => 'DEP-2026-0102',
    ],
    [
        'id' => 103,
        'nombre' => 'Kárate infantil',
        'categoria' => 'Artes marciales',
        'capacidad' => 10,
        'minutos' => 60,
        'monitor' => 'Lucía Gil',
        'codigo' => 'DEP-2026-0103',
    ],
    [
        'id' => 104,
        'nombre' => 'Pádel avanzado',
        'categoria' => 'Raqueta',
        'capacidad' => 4,
        'minutos' => 90,
        'monitor' => 'Óscar Ruiz',
        'codigo' => 'DEP-2026-0104',
    ],
    [
        'id' => 105,
        'nombre' => '  Órbita   fitness  ',
        'categoria' => 'Fitness',
        'capacidad' => 5,
        'minutos' => 30,
        'monitor' => null,
        'codigo' => 'DEP-2026-0105',
    ],
];

$reservas = [
    [
        'id' => 1,
        'actividadId' => 101,
        'plazas' => 3,
        'estado' => 'confirmada',
    ],
    [
        'id' => 2,
        'actividadId' => 101,
        'plazas' => 2,
        'estado' => 'confirmada',
    ],
    [
        'id' => 3,
        'actividadId' => 101,
        'plazas' => 2,
        'estado' => 'cancelada',
    ],
    [
        'id' => 4,
        'actividadId' => 102,
        'plazas' => 6,
        'estado' => 'confirmada',
    ],
    [
        'id' => 5,
        'actividadId' => 103,
        'plazas' => 4,
        'estado' => 'confirmada',
    ],
    [
        'id' => 6,
        'actividadId' => 104,
        'plazas' => 4,
        'estado' => 'confirmada',
    ],
    [
        'id' => 7,
        'actividadId' => 105,
        'plazas' => 1,
        'estado' => 'confirmada',
    ],
    [
        'id' => 8,
        'actividadId' => 103,
        'plazas' => 3,
        'estado' => 'cancelada',
    ],
];
