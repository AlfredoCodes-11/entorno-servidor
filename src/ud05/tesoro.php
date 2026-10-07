<?php
    # session_start() siempre antes de cualquier HTML
    session_start();

    # ---------- 1. Recuperamos el estado (sesión) o empezamos partida ----------
    # comprobamos que existan TODAS las claves; si falta alguna, partida nueva
    if (
        isset($_SESSION["pos"], $_SESSION["llave_recogida"], $_SESSION["cofre_abierto"],
              $_SESSION["inventario"], $_SESSION["estado"])
        && !isset($_GET["nueva"])
    ) {
        $posiciones     = $_SESSION["pos"];
        $llave_recogida = $_SESSION["llave_recogida"];
        $cofre_abierto  = $_SESSION["cofre_abierto"];
        $inventario     = $_SESSION["inventario"];
        $estado         = $_SESSION["estado"];
    } else {
        # posiciones de los elementos (0 = tesoro, 1 = trampa, 2 = cofre, 3 = llave)
        $posiciones = [];

        for ($i = 1; $i <= 4; $i++):
            do {
                $valor = rand(1, 100);
            } while (in_array($valor, $posiciones));

            $posiciones[] = $valor;
        endfor;

        $llave_recogida = 0;
        $cofre_abierto  = 0;
        $inventario     = 0;
        $estado         = "jugando";
    }

    # ---------- 2. Procesamos la casilla elegida ----------
    $mensaje = "";

    if (isset($_POST["posicion"]) && $estado == "jugando") {
        $posicion = $_POST["posicion"];

        if ($posicion < 1 || $posicion > 100) {
            $mensaje = "La casilla debe estar entre 1 y 100.";
        } elseif ($posicion == $posiciones[0]) {
            $estado  = "ganado";
            $mensaje = "🎉 ¡Has encontrado el tesoro! Has ganado.";
        } elseif ($posicion == $posiciones[1]) {
            $estado  = "perdido";
            $mensaje = "💥 Has caído en la trampa. Has perdido.";
        } elseif ($posicion == $posiciones[3] && $llave_recogida == 0) {
            $llave_recogida = 1;
            $inventario     = 1;
            $mensaje = "🔑 Has encontrado la llave. Se añade a tu inventario.";
        } elseif ($posicion == $posiciones[2] && $cofre_abierto == 0) {
            if ($inventario == 1) {
                $cofre_abierto = 1;
                $mensaje = "🎁 Has abierto el cofre con la llave. ¡Premio obtenido!";
            } else {
                $mensaje = "🔒 El cofre está cerrado. Necesitas la llave.";
            }
        } else {
            $mensaje = "No has encontrado nada.";
        }
    }

    # ---------- 3. Guardamos el estado en la sesión ----------
    $_SESSION["pos"]            = $posiciones;
    $_SESSION["llave_recogida"] = $llave_recogida;
    $_SESSION["cofre_abierto"]  = $cofre_abierto;
    $_SESSION["inventario"]     = $inventario;
    $_SESSION["estado"]         = $estado;
?>
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
            text-align: center;
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
                    $filas = 1;
                    for ($i = 1; $i <= 100; $i++):

                        # por defecto, el número de la casilla
                        $valor = str_pad($i, 3, "0", STR_PAD_LEFT);

                        # si hay un elemento visible, lo pintamos
                        if ($i == $posiciones[0]) {
                            $valor = "💎";
                        } elseif ($i == $posiciones[1]) {
                            $valor = "💥";
                        } elseif ($i == $posiciones[2] && $cofre_abierto == 0) {
                            $valor = "🔒";
                        } elseif ($i == $posiciones[3] && $llave_recogida == 0) {
                            $valor = "🔑";
                        }

                        if ($filas % 2 == 0) {
                            echo "<td class=\"" . (($i % 2 == 0) ? "fondo-par" : "impar") . "\">$valor</td>\n";
                        } else {
                            echo "<td class=\"" . (($i % 2 == 0) ? "par" : "fondo-impar") . "\">$valor</td>\n";
                        }

                        if ($i % 10 == 0 && $i < 91) {
                            echo "</tr><tr>\n";
                            $filas++;
                        }

                    endfor;
                    ?>
                </tr>
            </tbody>
        </table>

        <?php
        echo "<p>$mensaje</p>";

        if ($inventario == 1) {
            echo "<p>Inventario: 🔑</p>";
        } else {
            echo "<p>Inventario: vacío</p>";
        }

        # el formulario solo se muestra mientras se juega
        if ($estado == "jugando") {
            echo "<form action=\"tesoro.php\" method=\"post\">";
            echo "<label for=\"numero\">Posición</label>";
            echo "<input id=\"numero\" type=\"number\" name=\"posicion\" min=\"1\" max=\"100\" autofocus required>";
            echo "<button>Enviar</button>";
            echo "</form>";
        }
        ?>

        <a href="tesoro.php?nueva=1" class="btn btn-secondary mt-2">Nueva partida</a>
    </div>
</body>

</html>