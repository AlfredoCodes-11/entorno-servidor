<?php

    require_once "secreto.php";
    session_start();

    if (isset($_POST["nueva"])):
        $_SESSION = [];
        session_destroy();
        header("Location: proyecto.php");
        exit;
    endif;


    if (!isset($_SESSION["codigo"])):
        $_SESSION["puerta"] = 1;
        generarCodigo();
    endif;

    if (isset($_POST["siguiente"]) and $_SESSION["estado"] == "victoria" and $_SESSION["puerta"] < 3):
        $_SESSION["puerta"] += 1;
        generarCodigo();
    endif;

    $mensaje = "";
    $final = "";
    $finalizado = false;
    
    echo $_SESSION["codigo"];


    if (isset($_POST["codigo-introducido"]) and $_SESSION["estado"] == "jugando"):

        $codigo = $_POST["codigo-introducido"];

        if ($codigo < 1000 || $codigo > 9999):
            $mensaje = "El código debe ser entre 1000 y 9999";
        else:
            if (comprobarCodigo($codigo)):
                $_SESSION["estado"] = "victoria";
            else:
                $_SESSION["intentos"] -= 1;
                if ($_SESSION["intentos"] > 0):
                    $mensaje = "❌Código incorrecto. 💡 " . generarPista($codigo);
                else:
                    $_SESSION["estado"] = "bloqueada";
                endif;
            endif;
        endif;
    endif;

    if ($_SESSION["estado"] == "victoria"):
        $finalizado = true;
        if ($_SESSION["puerta"] == 3):
            $final = "¡Consiguiste abrir todas las puertas!";
        else:
            $final = "¡Victoria! Puerta desbloqueada";
        endif;
    elseif ($_SESSION["estado"] == "bloqueada"):
        $finalizado = true;
        $final = "¡Puerta Bloqueada!";
    endif;
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD 04</title>
</head>
<body>
    <div>
        <h3>🔐Puerta <?=$_SESSION["puerta"]?> - ACCESO PRINCIPAL</h3>
        <?php if (!$finalizado): ?>
            <form action="proyecto.php" method="post">
                <label for="codigo-introducido">Código:</label>
                <input id="codigo-introducido" type="number" name="codigo-introducido" autofocus required>
                <button type="submit">Desbloquear</button>
            </form>

            <?php if ($mensaje != "") : ?>
                <p><?=$mensaje?></p>
            <?php endif; ?>

            <p>Intentos restantes: <?=$_SESSION["intentos"]?></p>

        <?php elseif ($_SESSION["estado"] == "victoria" and $_SESSION["puerta"] < 3): ?>
            <h4><?=$final?></h4>
            <form action="proyecto.php" method="post">
                <button type="submit" name="nueva" value="1">Nueva Partida</button>
                <button type="submit" name="siguiente" value="1">Siguiente puerta</button>
            </form>

        <?php else: ?>
            <h4><?=$final?></h4>
            <form action="proyecto.php" method="post">
                <button type="submit" name="nueva" value="1">Nueva Partida</button>
            </form>
        <?php endif; ?>

    </div>
</body>
</html>