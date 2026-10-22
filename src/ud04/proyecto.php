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
        $_SESSION["codigo"] = random_int(1000,9999);
        $_SESSION["intentos"] = 6;
        $_SESSION["puerta"] = 1;
    endif;

    if (isset($_POST["siguiente"])):
        $_SESSION["codigo"] = random_int(1000,9999);
        $_SESSION["puerta"] += 1;
    endif;

    $mensaje = "";
    $final = "";
    $finalizado = false;
    

    echo $_SESSION["codigo"];

   
    

    if (isset($_POST["codigo-introducido"])):

        $codigo = $_POST["codigo-introducido"];

        if ($_POST["codigo-introducido"] < 1000 || $_POST["codigo-introducido"] > 9999):
            $mensaje = "El código debe ser entre 1000 y 9999";
        else:
            if ($_POST["codigo-introducido"] == $_SESSION["codigo"]):
                $final = "¡Victoria! Puerta desbloqueada";
                $finalizado = true;
            elseif ($_SESSION["intentos"] > 0):
                $_SESSION["intentos"] -=1;
                if ($_POST["codigo-introducido"] < $_SESSION["codigo"]):
                    $mensaje = "❌Código incorrecto. 💡 El código es MAYOR.";
                else:
                    $mensaje = "❌Código incorrecto. 💡 El código es MENOR.";
                endif;
            else:
                $final = "¡Puerta Bloqueada!";
                $finalizado = true;
            endif;
        endif;
    endif;

    if ($_SESSION["puerta"] == 3):
        $final = "¡Consiguiste abrir todas las puertas!";
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
        <?php if ($_SESSION["intentos"] > 0 and !$finalizado): ?>
            <form action="proyecto.php" method="post">
                <label for="codigo-introducido">Código:</label>
                <input id="codigo-introducido" type="number" name="codigo-introducido" autofocus required>
                <button type="submit">Desbloquear</button>
            </form>

            <?php if ($mensaje != "") : ?>
                <p><?=$mensaje?></p>
            <?php endif; ?>
            
            <p>Intentos restantes: <?=$_SESSION["intentos"]?></p>

        <?php elseif ($_SESSION["puerta"] < 3 and $_SESSION["intentos"] > 1): ?>
            <h4><?=$final?></h4>
            <form action="proyecto.php" method="post">
                <button type="submit" name="nueva" value="1">Nueva Partida</button>
                <button type="submit" name="siguiente" value="1">Siguiente puerta</button>
            </form>
            
        <?php elseif ($_SESSION["puerta"] == 3 and $_SESSION["intentos"] > 1): ?>
            <h4><?=$final?></h4>
            <form action="proyecto.php" method="post">
                <button type="submit" name="nueva" value="1">Nueva Partida</button>
            </form>
        <?php elseif ($_SESSION["intentos"] == 0): ?>
             <form action="proyecto.php" method="post">
                <button type="submit" name="nueva" value="1">Nueva Partida</button>
            </form>
        <?php endif; ?>


    </div>
</body>
</html>