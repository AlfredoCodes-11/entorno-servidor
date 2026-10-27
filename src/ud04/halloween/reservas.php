<?php
    session_start();
    require_once "funciones.php";

    $habitaciones = [
            ["Numero" => 13, "Habitacion" => "Cripta real", "Precio" => 120, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ["Numero" => 66, "Habitacion" => "Laboratorio Frankenstein", "Precio" => 95, "Capacidad" => 3, "Disponibilidad" => "Disponible"],
            ["Numero" => 99, "Habitacion" => "Sarcófago Imperial", "Precio" => 150, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ["Numero" => 404, "Habitacion" => "Suite Fantasmal", "Precio" => 80, "Capacidad" => 1, "Disponibilidad" => "Disponible"],
            ["Numero" => 666, "Habitacion" => "Guarida del Hombre Lobo", "Precio" => 110, "Capacidad" => 2, "Disponibilidad" => "Disponible"],
            ];

    if (!isset($_SESSION["reservas"])) {
        $_SESSION["reservas"] = [];
    }

    $habitaciones = habitacionOcupada($habitaciones, $_SESSION["reservas"]);

    $error = "";
    $mensaje = "";
    $accion = $_POST["accion"] ?? "";

    if ($accion === "reservar") {
        $huesped = trim($_POST["huesped"] ?? "");
        $numero = (int) ($_POST["habitacion"] ?? 0);
        $noches = (int) ($_POST["noches"] ?? 0);

        $habSel = null;
        foreach ($habitaciones as $habitacion) {
            if ($habitacion["Numero"] === $numero) {
                $habSel = $habitacion;
            }
        }

        if ($huesped === "" || $noches < 1 || $habSel === null) {
            $error = "Debes indicar el huésped, seleccionar una habitación y las noches.";
        } elseif ($habSel["Disponibilidad"] !== "Disponible") {
            // Punto 5: no se reservan habitaciones ocupadas
            $error = "La habitación {$habSel['Numero']} está ocupada.";
        } else {
            $id = $_SESSION["siguiente_id"] ?? 1;

            $_SESSION["reservas"][] = [
                "id" => $id,
                "huesped" => $huesped,
                "numero" => $habSel["Numero"],
                "habitacion" => $habSel["Habitacion"],
                "precio" => $habSel["Precio"],
                "noches" => $noches,
                "estado" => "Activa",
            ];
            $_SESSION["siguiente_id"] = $id + 1;
            $mensaje = "Reserva nº $id confirmada.";
        }
    }

    // Cancelar una reserva (puntos 7 y 8)
    if ($accion === "cancelar") {
        $id = (int) ($_POST["id"] ?? 0);

        foreach ($_SESSION["reservas"] as $i => $reserva) {
            if ($reserva["id"] === $id && $reserva["estado"] === "Activa") {
                $_SESSION["reservas"][$i]["estado"] = "Cancelada";
                $mensaje = "Reserva nº $id cancelada. La habitación {$reserva['numero']} queda libre.";
            }
        }
    }

    // Se recalcula la ocupación tras reservar o cancelar
    $reservas = $_SESSION["reservas"];
    $habitaciones = habitacionOcupada($habitaciones, $reservas);

    // Resumen
    $total = count($reservas);
    $activas = 0;
    $canceladas = 0;
    $ingresos = 0;
    foreach ($reservas as $reserva) {
        if ($reserva["estado"] === "Activa") {
            $activas++;
            $ingresos += calcularEstancia($reserva["precio"], $reserva["noches"]);
        } else {
            $canceladas++;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
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
        <h3>Gestión de reservas</h3>
        <p>Registra nuevas reservas, consulta las existentes o cancela una reserva.</p>
    </div>

    <?php if ($error !== ""): ?>
        <p><strong><?= $error ?></strong></p>
    <?php endif; ?>

    <?php if ($mensaje !== ""): ?>
        <p><strong><?= $mensaje ?></strong></p>
    <?php endif; ?>

    <div>
        <h4>Nueva reserva</h4>
        <form action="reservas.php" method="post">
            <label for="huesped">Huésped:</label>
            <input id="huesped" type="text" name="huesped" required><br>

            <label for="habitacion">Habitación:</label>
            <select id="habitacion" name="habitacion" required>
                <option value="">-- Selecciona una habitación --</option>
                <?php foreach ($habitaciones as $habitacion): ?>
                    <option value="<?= $habitacion["Numero"] ?>" <?= $habitacion["Disponibilidad"] === "Disponible" ? '' : 'disabled' ?>>
                        <?= $habitacion["Numero"] ?> — <?= $habitacion["Habitacion"] ?>
                        (<?= $habitacion["Precio"] ?> €/noche · <?= $habitacion["Capacidad"] ?> personas · <?= $habitacion["Disponibilidad"] ?>)
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="noches">Número de noches:</label>
            <input id="noches" type="number" name="noches" min="1" required><br>

            <button type="submit" name="accion" value="reservar">Confirmar reserva</button>
        </form>
    </div>

    <div>
        <h4>Reservas actuales</h4>
        <?php if (empty($reservas)): ?>
            <p>No hay reservas registradas.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Nº</th><th>Huésped</th><th>Habitación</th><th>Noches</th>
                    <th>Importe</th><th>Estado</th><th>Acciones</th>
                </tr>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= $reserva["id"] ?></td>
                        <td><?= $reserva["huesped"] ?></td>
                        <td><?= $reserva["numero"] ?> — <?= $reserva["habitacion"] ?></td>
                        <td><?= $reserva["noches"] ?></td>
                        <td><?= calcularEstancia($reserva["precio"], $reserva["noches"]) ?> €</td>
                        <td><?= $reserva["estado"] ?></td>
                        <td>
                            <?php if ($reserva["estado"] === "Activa"): ?>
                                <form action="reservas.php" method="post">
                                    <input type="hidden" name="id" value="<?= $reserva["id"] ?>">
                                    <button type="submit" name="accion" value="cancelar">Cancelar</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div>
        <h4>Resumen</h4>
        <table>
            <tr>
                <td>Total de reservas:</td>
                <td><?= $total ?></td>
            </tr>
            <tr>
                <td>Reservas activas:</td>
                <td><?= $activas ?></td>
            </tr>
            <tr>
                <td>Reservas canceladas:</td>
                <td><?= $canceladas ?></td>
            </tr>
            <tr>
                <td>Ingresos previstos:</td>
                <td><?= $ingresos ?> €</td>
            </tr>
        </table>
    </div>
</body>
</html>