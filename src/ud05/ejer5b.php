<?php

    session_start();

    if (empty($_SESSION)) header("location: ejer5.php");

    if (isset($_GET["cerrar"])) {
        
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
    <p>Bienvenido/a, <? $_SESSION["usuario"]?></p>
</html>