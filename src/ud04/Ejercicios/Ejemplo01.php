<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 16</title>
</head>
<body>
    <?php


        const PUNTOS_EXTRA = 1.0;
        $nota_corte = 5.0;

        $alumnos = [
            ['nombre' => 'Laura', 'nota' => 8.5],
            ['nombre' => 'Pedro', 'nota' => 4.0],
            ['nombre' => 'Marta', 'nota' => 6.5],
            ['nombre' => 'Sergio', 'nota' => 3.0],
            ['nombre' => 'Carlos', 'nota' => 5.0],
            ['nombre' => 'Elena', 'nota' => 9.2],
            ['nombre' => 'David', 'nota' => 2.5],
            ['nombre' => 'Ana', 'nota' => 7.0],
            ['nombre' => 'Pablo', 'nota' => 4.8],
            ['nombre' => 'Lucía', 'nota' => 10.0],
        ];

        $aprobados = array_filter($alumnos, function ($fila) use ($nota_corte) 
        {
            return $fila["nota"] >= $nota_corte;
        });

        echo "<pre>" .print_r($aprobados) . "</pre>";


        // function sumar($valor) {
        //     return (PUNTOS_EXTRA + $valor);
        // }

        // $bonificacion = array_map('suma' , $alumnos);

        // echo "<pre>" .var_dump($bonificacion) . "</pre>";

    ?>
</body>
</html>
