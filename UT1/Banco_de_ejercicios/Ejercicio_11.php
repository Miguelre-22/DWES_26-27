<?php
    $codigo = "CF";

    // SWITCH
    switch ($codigo) {
        case "F":
            $generoSwitch = "Fantasía";
            break;
        case "CF":
            $generoSwitch = "Ciencia ficción";
            break;
        case "T":
            $generoSwitch = "Terror";
            break;
        default:
            $generoSwitch = "Desconocido";
    }

    // MATCH
    $generoMatch = match ($codigo) {
        "F" => "Fantasía",
        "CF" => "Ciencia ficción",
        "T" => "Terror",
        default => "Desconocido"
    };

    echo "Switch: " . $generoSwitch . "<br>";
    echo "Match: " . $generoMatch;
?>