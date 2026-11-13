<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');

var_dump($_GET['id'] ?? null);
var_dump($_POST['titulo'] ?? null);
var_dump($_SERVER['REQUEST_METHOD']);
