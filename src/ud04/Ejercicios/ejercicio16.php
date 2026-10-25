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
            ['nombre' => 'Elena', 'nota' => 0.2],
            ['nombre' => 'David', 'nota' => 9.2],
            ['nombre' => 'Ana', 'nota' => 7.0],
            ['nombre' => 'Pablo', 'nota' => 4.8],
            ['nombre' => 'Lucía', 'nota' => 10.0],
        ];

        $aprobados = array_filter($alumnos, function ($fila) use ($nota_corte) 
        {
            return $fila["nota"] >= $nota_corte;
        });

        echo "<pre>" . print_r($aprobados,true) . "</pre>";


        $bonificacion = array_map(function ($fila){
            return [
                "nombre" => $fila["nombre"],
                "nota" => $fila["nota"] + PUNTOS_EXTRA,
            ];
        } , $alumnos);

        echo "<pre>" . print_r($bonificacion,true) . "</pre>";

        $sumaTotal = array_reduce($alumnos, function ($acumulado, $fila) {
            return $acumulado + $fila["nota"];
        }, 0);

        echo "<pre>" . print_r($sumaTotal,true) . "</pre>";


        function contarSegunCriterio(array $alumnos, callable $criterio): int {
        $contador = 0;

        foreach ($alumnos as $alumno) {
            if ($criterio($alumno)) {
                $contador++;
            }
        }

        return $contador;
        };

    
        $sobresalientes = contarSegunCriterio($alumnos, function ($alumno) {
            return $alumno['nota'] >= 9;
        });


        $criticos = contarSegunCriterio($alumnos, function ($alumno) {
            return $alumno['nota'] < 4;
        });

        $nombresLargos = contarSegunCriterio($alumnos, function ($alumno) {
            return mb_strlen($alumno['nombre']) > 4;
        });

        $empiezanPorP = contarSegunCriterio($alumnos, function ($alumno) {
            return str_starts_with($alumno['nombre'], 'P');
        });

        echo "Sobresalientes (>= 9): $sobresalientes<br>";
        echo "Estado crítico (< 4): $criticos<br>";
        echo "Nombre con más de 4 caracteres: $nombresLargos<br>";
        echo "Nombre que empieza por P: $empiezanPorP<br>";


    ?>
</body>
</html>
