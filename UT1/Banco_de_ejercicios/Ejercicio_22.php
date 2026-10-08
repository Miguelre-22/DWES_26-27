<?php
    //declare(strict_types=1);

    function esLargo($numeroPaginas) {
        if ($numeroPaginas > 500) {
            return true;
        }
    }

    echo esLargo(550);
?>