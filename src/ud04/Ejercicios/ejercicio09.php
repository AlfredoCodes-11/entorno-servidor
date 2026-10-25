<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 09</title>
</head>
<body>
    <?php

        function calcularTotal(float $precio, $iva = 21, $descuento = 0):float{
            
            $total = $precio - (($precio * $descuento) / $precio);
            $total = (($total * $iva) / $total) + $total;
            return $total;
            
        }

        echo calcularTotal(100);
        echo "<br>";
        echo calcularTotal(100,21,50);

    ?>
</body>
</html>