<?php

    require_once "funciones.php";

    $habitaciones = [
            ["Numero" => 13, "Habitacion" => "Cripta real", "Precio" => 120, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ["Numero" => 66, "Habitacion" => "Laboratorio Frankenstein", "Precio" => 95, "Capacidad" => 3, "Disponibilidad" => "Disponible"],
            ["Numero" => 99, "Habitacion" => "Sarcófrago Imperial", "Precio" => 150, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ["Numero" => 404, "Habitacion" => "Suite Fantasmal", "Precio" => 80, "Capacidad" => 1, "Disponibilidad" => "Disponible"],
            ["Numero" => 666, "Habitacion" => "Guarida del Hombre Lobo", "Precio" => 110, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ];

    $resultado = null;
    $seleccionada = null;

    if (!empty($_POST["habitacion"]) && !empty($_POST["noches"])) {
        $seleccionada = (int) $_POST["habitacion"];
        $noches = (int) $_POST["noches"];

        foreach ($habitaciones as $h) {
            if ($h["Numero"] === $seleccionada) {
                $resultado = [
                    "habitacion" => $h["Habitacion"],
                    "numero" => $h["Numero"],
                    "precio" => $h["Precio"],
                    "noches" => $noches,
                    "total" => calcularEstancia($h["Precio"], $noches),
                ];
            }
        }
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
        <h3>Habitaciones del Hotel</h3>
        <p>Selecciona una habitación disponible para calcular el precio de la estacia.</p>
    </div>
    <div>
        <h4>Habitaciones</h4>
        <form action="habitaciones.php" method="post">
            <table>
                <tr>
                    <th>Nº</th><th>Nombre</th><th>Precio/noche</th>
                    <th>Capacidad</th><th>Estado</th><th>Seleccionar</th>
                </tr>
                <?php mostrarHabitaciones($habitaciones, $seleccionada); ?>
            </table>

            <label for="noches">Número de noches:</label>
            <input id="noches" type="number" name="noches" min="1"
                value="<?= $_POST["noches"] ?? '' ?>" required>
            <button type="submit">Calcular importe</button>
        </form>
    </div>

    <div>
        <h4>Calcular estacia</h4>
        <p>Habitación seleccionada:</p><br>
        <p><?=$_SESSION["habitacion"][0]?>---<?=$_SESSION["habitacion"][1]?></p><br>
        <p><?=$_SESSION["habitacion"][2]?>€/noche · Capacidad: <?=$_SESSION["habitacion"][1]?></p><br>
    </div>
        
</body>
</html>