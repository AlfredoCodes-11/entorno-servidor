<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protocolo GET</title>
</head>
<body>
    <?php

        #echo "<pre>" . print_r($_GET, true) . "</pre>";
        if (!empty($_GET)):
            echo "Hola, " . $_GET["nombre"] . "<br/>";
            echo "Edad:" . $_GET["edad"] . "<br/>";
        endif;
        

    ?>
    <!-- <form action="procesarGet.php" method="get"> -->
    <form action="get.php" method="get">
        <label for="nombre">Introduce tu nombre: </label>
        <input id="nombre" type="text" name="nombre" autofocus>

        <br/>

        <label for="nombre">Introduce tu edad: </label>
        <input id="edad" type="text" name="edad">

        <button>Enviar</button>

    </form>


</body>
</html>