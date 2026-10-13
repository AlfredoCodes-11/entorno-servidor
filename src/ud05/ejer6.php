<?php

    session_start();

    $_SESSION["carrito"] = $_POST["catalogo"];
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ejer6.php" method="post">
        <label for="catalogo">Catálogo:</label>
        <select name="catalogo[]" id="catalogo" multiple>
            <option value="1">Cascos</option>
            <option value="2">Teclado</option>
            <option value="3">Ratón</option>
            <option value="4">Monitor</option>
        </select>
        <button>Guardar</button>
    </form>
</body>
</html>