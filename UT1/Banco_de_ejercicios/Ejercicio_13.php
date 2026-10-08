<?php
    for ($i = 1; $i <= 30; $i++) {
        if ($i % 5 == 0) {
            continue;
        }

        if ($i == 26) {
            break;
        }

        echo $i . PHP_EOL;
    }
?>