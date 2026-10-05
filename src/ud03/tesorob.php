<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 03</title>
    <style>
        table {
            border: 1px solid #000;
            margin-bottom: 10px;
        }

        td {
            padding: 5px;
            text-aling: center;
            font-weight: bold;
        }

        .par {
            color: #fcba03;
        }

        .impar {
            color: #0317fc;
        }

        .fondo-par {
            color: #fcba03;
            background-color: #918f8e;
        }

        .fondo-impar {
            color: #0317fc;
            background-color: #918f8e;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>Tablero</h2>
        <table>
            <tbody>
                <tr>
                    <?php
                    # posiciones de los elementos
                    $posiciones = [];

                    # colocamos los elementos
                    if (!isset($_POST["posicion"])) {
                        for ($i = 1; $i <= 4; $i++):
                            do {
                                $valor = rand(1, 100);
                            } while (in_array($valor, $posiciones));

                            # guardamos el valor en el array
                            $posiciones[] = $valor;
                        endfor;
                    } else {
                        $posiciones = $_POST["pos"];
                    }

                    $ganado = false;

                    if (isset($_POST["posicion"])) {
                        if ($_POST["posicion"] == $posiciones[0]) {
                            $ganado = true;
                        }
                    }

                    $filas = 1;
                    for ($i = 1; $i <= 100; $i++):




                        # comprobamos si hay algún elemento en la celda y lo pintamos
                        $valor = match (array_search($i, $posiciones)) {
                            0 => "💎",
                            1 => "💥",
                            2 => "🔒",
                            3 => "🔑",
                            default => str_pad($i, 3, "0", STR_PAD_LEFT)
                        };

                        if ($filas % 2 == 0) {
                            echo "<td class=\"" . (($i % 2 == 0) ? "fondo-par" : "impar") . "\">$valor</td>\n";
                        } else {
                            echo "<td class=\"" . (($i % 2 == 0) ? "par" : "fondo-impar") . "\">$valor</td>\n";
                        }

                        //echo "<td class=\"" . (($i%2==0)?"par":"impar") . "\">$valor</td>\n";
                    
                        if ($i % 10 == 0 && $i < 91) {
                            echo "</tr><tr>\n";
                            $filas++;
                        }

                    endfor;


                    ?>



                </tr>
            </tbody>

        </table>

        <!-- Formulario de juego -->
        <!-- <form action="tesorob.php" method="post"> -->
        <!-- <input type="hidden" name="diamante" value=">"> -->
        <!-- <label for="numero">Posición</label> -->
        <!-- <input id="numero" type="number" name="posicion" min="1" max="100" autofocus required> -->
        <!-- <button>Enviar</button> -->
        <!-- </form> -->

        <?php
        if ($ganado) {
            echo "<h2>¡Has encontrado el tesoro!</h2>";
        } else {
            echo "<form action=\"tesorob.php\" method=\"post\">";

            foreach ($posiciones as $valor) {
                echo "<input type=\"hidden\" name=\"pos[]\" value=\"$valor\">";
            }
            echo "<label for=\"numero\">Posición</label>";
            echo "<input id=\"numero\" type=\"number\" name=\"posicion\" min=\"1\" max=\"100\" autofocus required>";
            echo "<button>Enviar</button>";
            echo "</form>";

        }
        ?>

        <a href="tesorob.php"><button>Reiniciar</button></a>

        <?php

        if (isset($_POST["posicion"])) {
            $posicion_player = $_POST["posicion"];
            $tesoro = $posiciones[0];
        }

        ?>

        <!-- Ver si se puede mandar el array -->
    </div>
</body>

</html>