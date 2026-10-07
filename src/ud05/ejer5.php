<?php

    session_start();

    $nombre = "alfredo";
    $contraseña = "1234";

    if ((isset($_POST["nombre"])) && (isset($_POST["contraseña"]))){
        $nombre_introducido = $_POST["nombre"];
        $contra_introducida = $_POST["contraseña"];

        if ($nombre_introducido == $nombre && $contra_introducida == $contraseña) {
            $_SESSION["nombre"] = $nombre_introducido;
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
    <?php if (empty($_SESSION)): ?>
    <form action="ejer5.php" method="post">
        <label for="nombre">Nombre:</label>
        <input id="nombre" type="text" name="nombre" autofocus required><br>
        <label for="contraseña">Contraseña:</label>
        <input id="contraseña" type="password" name="contraseña" required><br>
        <button>Entrar</button>
    <?php else: ?>
        <h1>Hola bienvenido a la zona privada.</h1>
        <p><a href="ejer5.php">Cerrar sesión</a></p>
        <?php
            $_SESSION = [];
            session_destroy();
        ?>

    <?php endif; ?>
    </form>
</body>
</html>