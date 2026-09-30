<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
    <?php

    $edad = $_GET["edad"]??"-";

    echo "Hola, $_GET[nombre], tienes $edad años.<br/>";

    ?>


</body>
</html>