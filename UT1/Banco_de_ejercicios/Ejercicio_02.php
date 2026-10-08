<?php
    $a = 25; // Int
    $b = 25.7; // Float
    $c = "25"; // String
    $d = true; // Bool
    $e = null; // Null

    $aDecimal = (float) $a;
    $bEntero = (int) $b;
    $cEntero = (int) $c;
    $cDecimal = (float) $c;
    $aBool = (bool) $a;

    echo $a . "\n"; 
    echo $b . "\n";
    echo $c . "\n";
    echo $d . "\n";
    echo $e . "\n";

    echo $aDecimal . "\n";
    echo $bEntero . "\n";
    echo $cEntero . "\n";
    echo $cDecimal . "\n";
    echo $aBool . "\n";
?>
