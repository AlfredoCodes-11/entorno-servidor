<?php

    session_start();

    $nombre = "alfredo";
    $contraseña = "1234";

    if ((isset($_POST["nombre"])) && (isset($_POST["contraseña"]))){
        $nombre_introducido = $_POST["nombre"];
        $contra_introducida = $_POST["contraseña"];

        if ($nombre_introducido == $nombre && $contra_introducida == $contraseña) {
            $_SESSION["nombre"] = $nombre_introducido;
            header("location: ejer5b.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 05</title>
</head>
<body>
    <form action="ejer5.php" method="post">
        <label for="nombre">Nombre:</label>
        <input id="nombre" type="text" name="nombre" autofocus required><br>
        <label for="contraseña">Contraseña:</label>
        <input id="contraseña" type="password" name="contraseña" required><br>
        <button>Entrar</button>
    </form>
</body>
</html>