<?php
    $a = (5 == "5");
    $b = (5 === "5");
    $c = (10 > 5 && 3 < 2);
    $d = !$b || $c;
    
    // La variable $a nos daría true ya que "==" compara y convierte el tipo.

    // La variable $b nos daría false ya que "===" al ser igualdad estricta no convierte el tipo.

    // La variable $c nos daría false ya que "&&" actúa como un AND, por lo tanto para que de true se tendrían que 
    // cumplirambas condiciones. Y en este caso se cumple la primera pero no la segunda. 

    // La variable $d nos daría true ya que "||" actúa como un OR, por lo tanto como al poner "!" delante 
    // de la variable $b esta se convierte en true y la variable $c es false. Pues true OR false nos da true.
?>
