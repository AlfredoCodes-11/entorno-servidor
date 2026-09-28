<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 03</title>
    <style>
        ul { list-style-type: none;}
        li {font-weight:bold;}
        .par {color:#fcba03;}
        .impar {color:#0317fc;}
    </style>
</head>
<body>
    
    <ul>

        <?php
            for($i = 1; $i <= 100; $i++):
                echo "<li class=\"" . (($i%2==0)?"par":"impar") . "\">$i</li>";
            endfor;
        ?>

    </ul>

</body>
</html>