<?php
$base = file_get_contents(__DIR__ . "/base.png");
if ($base === false || strlen($base) >= 2 * 1024 * 1024) {
 exit("Prepara un PNG menor de 2 MiB.");
}
foreach ([2097152, 2097153] as $bytes) {
 $contenido = $base . str_repeat("\0", $bytes - strlen($base));
 file_put_contents(__DIR__ . "/limite-$bytes.png", $contenido);
}