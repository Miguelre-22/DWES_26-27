<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');

var_dump($_POST);
var_dump($_POST['paginas'] ?? null);
