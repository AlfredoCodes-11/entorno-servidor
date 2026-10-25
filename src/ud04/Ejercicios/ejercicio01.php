<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 01</title>
</head>
<body>
    <?php

        function saludar(string $nombre): string{
            return "Hola, bienvenido, $nombre"; 
        }


        echo saludar("Antonio");
        echo "</br>";
        echo saludar("Lucía");
        echo "</br>";
        echo saludar("Alejandro");
        echo "</br>";

    ?>
</body>
</html>