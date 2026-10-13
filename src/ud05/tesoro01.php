<?php
    session_start();

    if (isset($_POST["nueva"])):
        $_SESSION = [];
        session_destroy();
        header("Location: tesoro01.php");
    endif;

    if (isset($_SESSION["pos"],$_SESSION["llave_recogida"],$_SESSION["cofre_abierto"],$_SESSION["inventario"],$_SESSION["estado"]) and !isset($_POST["nueva"])):
        $posiciones = $_SESSION["pos"];
        $llave_recogida = $_SESSION["llave_recogida"];
        $cofre_abierto = $_SESSION["cofre_abierto"];
        $inventario = $_SESSION["inventario"];
        $estado = $_SESSION["estado"];
    else :
        $posiciones = [];

        for ($i = 1; $i <= 4; $i++):
            do {
                $valor = rand(1,100);
            } while (in_array($valor,$posiciones));
            
            $posiciones[] = $valor;
        endfor;

        $llave_recogida = 0;
        $cofre_abierto = 0;
        $inventario = 0;
        $estado = "jugando";
    endif;

    $mensaje = "";

    if (isset($_POST["posicion"]) and $estado == "jugando"):
        $posicion = $_POST["posicion"];
        if ($posicion < 1 || $posicion > 100):
            $mensaje = "Debes introducir un número entre el 1 y el 100";
        elseif ($posicion == $posiciones[0]):
            $mensaje = "¡Has encontrado el tesoro!";
                $estado = "ganado";
        elseif ($posicion == $posiciones[1]):
            $mensaje = "¡Has caido en una trampa!";
            $estado = "perdido";
        elseif ($posicion == $posiciones[3] and $llave_recogida == 0):
            $llave_recogida = 1;
            $inventario = 1;
            $mensaje = "¡Has encontrado la llave!";
        elseif ($posicion == $posiciones[2] and $cofre_abierto == 0):
            if ($inventario == 1):
                $inventario = 0;
                $cofre_abierto = 1;
                $mensaje = "¡Has abierto el cofre!";
            else :
                $mensaje = "No tienes la llave del cofre.";
            endif;
        else:
            $mensaje = "No encontraste nada";
        endif;
    endif;

    $_SESSION["pos"] = $posiciones;
    $_SESSION["llave_recogida"] = $llave_recogida;
    $_SESSION["cofre_abierto"] = $cofre_abierto;
    $_SESSION["inventario"] = $inventario;
    $_SESSION["estado"] = $estado;


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio tesoro</title>
</head>
<body>
    <h1>Tablero</h1>
    <table>
        <tr>
            <?php

                for ($i = 1; $i <= 100; $i++ ):
                    $valor = str_pad($i,3,"0",STR_PAD_LEFT);
                    
                    if($i == $posiciones[0]):
                        $valor = "💎";
                    elseif ($i == $posiciones[1]):
                        $valor = "💥";
                    elseif ($i == $posiciones[2] and $cofre_abierto == 0):
                        $valor = "🔒";
                    elseif ($i == $posiciones[3] and $llave_recogida == 0):
                        $valor = "🔑";
                    endif;

                    echo "<td>" . $valor . "</td>\n";

                    if ($i % 10 == 0 && $i < 91):
                        echo "</tr><tr>";
                    endif;
                endfor;

            ?>
        </tr>
    </table>

    <?php
        echo "<p>" . $mensaje . "</p";
    ?>

    <?php
        if ($inventario == 1):
            echo "<p>Inventario: 🔑</p>";
        else:
            echo "<p>Inventario: vacio</p>";
        endif;
    ?>

    <?php if ($estado == "jugando"): ?>
        <form action="tesoro01.php" method="post">
            <label for="numero">Posición</label>
            <input id="numero" type="number" name="posicion" min="1" max="100" autofocus required>
            <button>Enviar</button>
        </form>
    <?php endif; ?>
    <form action="tesoro01.php" method="post">
        <button name="nueva" value="1">Nueva partida</button>
    </form>
</body>
</html>