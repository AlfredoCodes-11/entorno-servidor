<?php

    $mensaje = "";
    $tema = 0;

    

    if (isset($_POST["nombre"]) && isset($_POST["tema"])) {
        setcookie("nombre",$_POST["nombre"], time() + 30*24*60*60);
        setcookie("tema",$_POST["tema"], time() + 30*24*60*60);
        header("Location:http://localhost:8080/ud05/ejer3b.php");
    }

    if (isset($_COOKIE["nombre"]) and isset($_COOKIE["tema"])) {
        $mensaje = "<p>Bienvenido/a, {$_COOKIE['nombre']}</p>";
        $tema = $_COOKIE["tema"];
    }

    $temas = ["Claro","Oscuro","Cálido","Frío"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 03</title>
    <style>

        <?php switch ($tema): 
            case 0: ?>
            body {background-color:#F5F7F6; color: #1F2933;}
            <?php break;
            case 1: ?>
            body {background-color:#F5F7F6; color: #1F2933;}
            <?php break;
            case 2: ?>
            body {background-color:#1E2723; color: #E8F0EC;}
            <?php break;
            case 3: ?>
            body {background-color:#FFF1DC; color: #653C20;}
            <?php break;
            case 4: ?>
            body {background-color:#E8F3F8; color: #193A4A;}
            <?php break;
            endswitch; ?>
    </style>

</head>
<body>

    <?= $mensaje ?>

    <form action="ejer3b.php" method="post">
        <label for="nombre">Nombre:</label>
        <input id="nombre" type="text" name="nombre" autofocus required>
        <br>
        <label for="tema">Temas:</label>
        <select name="tema" id="tema">
            <?php foreach($temas as $indice => $valor): ?>
                <option value="<?=$indice ?>"><?= $valor ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>