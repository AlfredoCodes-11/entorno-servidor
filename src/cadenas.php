<?php

    # Variables de tipo Cadena
    $valor = 15;
    echo "El precio del artículo es: {$valor}€<br/>";
    echo 'El precio del articulo es $valor<br/>';

    # Tipo Array
    $a = [6, -1, 3, 23, 8 ,11];

    print_r($a);

    echo "<br/>";

    $resultado = is_array($a);

    var_dump($resultado);

    echo "<br/>";

    unset($a[5]);
    print_r($a);

    echo "<br/>";

    $a[] = 999;
    print_r($a);

    $b = ["a" => 1, "d" => 5];
    $c = ["a" => 2,3,6];
    $d = ["c" => 4, ...$b, ...$c];

    echo "<br/>";
    print_r($d);

    echo "<br/>";

    $resultado1 = "   hola, clase de dwes   " |> trim(...) |> strtoupper(...);
    echo "$resultado1<br/>";

    echo "<pre>" . print_r($resultado1, true) . "</pre>";
?>