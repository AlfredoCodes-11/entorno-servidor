<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>¡Hola mundo PHP!</title>
    </head>
    <body>
        <?php
            $total = 0;
            for ($i = 0; $i < 5; $i++) {
                $total += $i;
                echo $total;
                echo "<br>";
            }
        
            echo "¡Hola mundo!"; 
            echo "<br>";
        ?>
        <br>
    </body>
</html>