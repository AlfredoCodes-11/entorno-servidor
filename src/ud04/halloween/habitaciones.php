<?php
    session_start();
    require_once "funciones.php";

    $habitaciones = [
            ["Numero" => 13, "Habitacion" => "Cripta real", "Precio" => 120, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ["Numero" => 66, "Habitacion" => "Laboratorio Frankenstein", "Precio" => 95, "Capacidad" => 3, "Disponibilidad" => "Disponible"],
            ["Numero" => 99, "Habitacion" => "Sarcófago Imperial", "Precio" => 150, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ["Numero" => 404, "Habitacion" => "Suite Fantasmal", "Precio" => 80, "Capacidad" => 1, "Disponibilidad" => "Disponible"],
            ["Numero" => 666, "Habitacion" => "Guarida del Hombre Lobo", "Precio" => 110, "Capacidad" => 2, "Disponibilidad" => "Ocupada"],
            ];

    $habitaciones = habitacionOcupada($habitaciones, $_SESSION["reservas"] ?? []);

    $error = "";

    if (($_POST["accion"] ?? "") === "seleccionar") {
        $numero = (int) ($_POST["habitacion"] ?? 0);

        $habSel = null;
        foreach ($habitaciones as $h) {
            if ($h["Numero"] === $numero) {
                $habSel = $h;
            }
        }

        if ($habSel === null) {
            $error = "Debes seleccionar una habitación.";
        } elseif ($habSel["Disponibilidad"] !== "Disponible") {
            // Punto 7
            $error = "La habitación {$habSel['Numero']} está ocupada.";
        } else {
            $_SESSION["habitacion"] = $habSel;
            unset($_SESSION["estancia"]); 
        }
    }

    if (($_POST["accion"] ?? "") === "calcular") {
        $huesped = trim($_POST["nombre"] ?? "");
        $noches = (int) ($_POST["noches"] ?? 0);

        if (!isset($_SESSION["habitacion"])) {
            $error = "Primero debes seleccionar una habitación.";
        } elseif ($huesped === "" || $noches < 1) {
            $error = "Debes indicar el nombre del huésped y las noches.";
        } else {
            $_SESSION["estancia"] = [
                "nombre" => $huesped,
                "noches" => $noches,
            ];
        }
    }

    $habSel = $_SESSION["habitacion"] ?? null;
    $estancia = $_SESSION["estancia"] ?? null;
    $seleccionada = $habSel["Numero"] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones</title>
</head>
<body>
    <h2>HOTEL NOCTURNA</h2>
    <nav>
        <ul>
            <li><a href="halloween.php">Inicio</a></li>
            <li><a href="habitaciones.php">Habitaciones</a></li>
            <li><a href="reservas.php">Reservas</a></li>
            <li><a href="huespedes.php">Huéspedes</a></li>
            <li><a href="servicios.php">Servicios</a></li>
        </ul>
    </nav>

    <div>
        <h3>Habitaciones del Hotel</h3>
        <p>Selecciona una habitación disponible para calcular el precio de la estancia.</p>
    </div>

    <?php if ($error !== ""): ?>
        <p><strong><?= $error ?></strong></p>
    <?php endif; ?>

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
            <button type="submit" name="accion" value="seleccionar">Seleccionar habitación</button>
        </form>
    </div>

    <div>
        <h4>Calcular estancia</h4>
        <?php if ($habSel): ?>
            <p>Habitación seleccionada:</p>
            <p><?= $habSel["Numero"] ?> — <?= $habSel["Habitacion"] ?></p>
            <p><?= $habSel["Precio"] ?> €/noche · Capacidad: <?= $habSel["Capacidad"] ?> personas</p>

            <form action="habitaciones.php" method="post">
                <label for="nombre">Nombre del huésped:</label>
                <input id="nombre" type="text" name="nombre" required><br>

                <label for="noches">Número de noches:</label>
                <input id="noches" type="number" name="noches" min="1" required><br>

                <button type="submit" name="accion" value="calcular">Calcular importe</button>
            </form>
        <?php else: ?>
            <p>Habitación seleccionada: Ninguna</p>
        <?php endif; ?>
    </div>

    <?php if ($habSel && $estancia): ?>
        <div>
            <h4>Resultado de la estancia</h4>
            <table>
                <tr>
                    <td>Habitación:</td>
                    <td><?= $habSel["Habitacion"] ?> (nº <?= $habSel["Numero"] ?>)</td>
                </tr>
                <tr>
                    <td>Huésped:</td>
                    <td><?= $estancia["nombre"] ?></td>
                </tr>
                <tr>
                    <td>Precio por noche:</td>
                    <td><?= $habSel["Precio"] ?> €</td>
                </tr>
                <tr>
                    <td>Noches:</td>
                    <td><?= $estancia["noches"] ?></td>
                </tr>
            </table>

            <h4>Total de la estancia: <?= calcularEstancia($habSel["Precio"], $estancia["noches"]) ?> €</h4>
        </div>
    <?php endif; ?>
</body>
</html>