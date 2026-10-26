<?php

        session_start();

       require_once "funciones.php";

        if (empty($_SESSION) and !empty($_POST)) {
            $_SESSION["nombre"] = $_POST["nombre"];
            $_SESSION["precio"] = $_POST["precio"];
            $_SESSION["noches"] = $_POST["noches"];
        }



    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halloween</title>
    <h2>HOTEL NOCTURNA</h2>
    <nav>
        <ul>
            <li><a href="halloween.php">Inicio</a></li>
            <li><a href="habitaciones.php">Habitaciones</a></li>
            <li><a href="reservas.php">Reservas</a></li>
            <li><a href="huespedes.php">Húespedes</a></li>
            <li><a href="servicios.php">servicios</a></li>
        </ul>
    </nav>
</head>
<body>
    <div>
        <form action="halloween.php" method="post">
            <label for="nombre">Nombre:</label>
            <input id="nombre" type="text" name="nombre" required autofocus><br>
            <label for="precio">Precio:</label>
            <input id="precio" type="number" name="precio" min="0" required><br>
            <label for="nombre">Número de noches:</label>
            <input id="noches" type="number" name="noches" min="0" required><br>
            <button type="submit">Calcular importe</button>
        </form>
    </div>
    <?php if (!empty($_SESSION)): ?>
        <div>
            <h4>Resultado de la estancia</h4>
            <table>
                <tr>
                    <td>Húesped:</td>
                    <td><?=$_SESSION["nombre"]?></td>
                </tr>
                <tr>
                    <td>Precio por noche:</td>
                    <td><?=$_SESSION["precio"]?></td>
                </tr>
                <tr>
                    <td>Noches:</td>
                    <td><?=$_SESSION["noches"]?></td>
                </tr>
            </table>

            <h4>Total de la estancia: <?=calcularEstancia($_SESSION["precio"],$_SESSION["noches"])?></h4>
        </div>
        <?php endif; ?>
</body>
</html>