<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    
   <?php
    $diamante = $_POST['diamante'];
    $posicion = $_POST['posicion'];

    if ($posicion == $diamante) {
        echo "<h2>¡Has encontrado el tesoro!</h2>";
        echo "<a href=\"tesoro.php\">Jugar de nuevo</a>";
    } else {
         echo "<h2>¡Has fallado!</h2>";
        echo "<a href=\"tesoro.php\">Jugar de nuevo</a>";
    }
?>


</body>
</html>