<?php

require_once 'modelos/Habitacion.php';
require_once 'modelos/Huesped.php';
require_once 'modelos/Reserva.php';

session_start();

if (!isset($_SESSION['habitaciones'])) {
    $_SESSION['habitaciones'] = [
        13 => new Habitacion(13, 'Cripta real', 120, 2),
        66 => new Habitacion(66, 'Laboratorio Frankenstein', 95, 3),
        99 => new Habitacion(99, 'Sarcófago Imperial', 150, 2),
        404 => new Habitacion(404, 'Suite Fantasmal', 80, 1),
        666 => new Habitacion(666, 'Trono de Lucifer', 110, 2),
    ];
    $_SESSION['huespedes'] = [];
    $_SESSION['reservas'] = [];
}

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    try {
        if ($accion === 'registrar_huesped') {
            $nombrePila = trim($_POST['nombre_pila'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            if ($nombrePila === '' || $apellidos === '') {
                throw new InvalidArgumentException('El nombre de pila y los apellidos son obligatorios.');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('El correo electrónico no es válido.');
            }
            if ($telefono === '') {
                throw new InvalidArgumentException('El teléfono es obligatorio.');
            }

            $id = count($_SESSION['huespedes']) + 1;
            $huesped = new Huesped($id, $nombrePila, $apellidos, $email, $telefono);
            $_SESSION['huespedes'][$id] = $huesped;
            $_SESSION['mensaje'] = 'Huésped registrado: ' . $huesped->nombre;

        } elseif ($accion === 'realizar_reserva') {
            $idHuesped = (int) ($_POST['huesped'] ?? 0);
            $numHabitacion = (int) ($_POST['habitacion'] ?? 0);
            $noches = (int) ($_POST['noches'] ?? 0);

            if (!isset($_SESSION['huespedes'][$idHuesped])) {
                throw new InvalidArgumentException('Debes seleccionar un huésped válido.');
            }
            if (!isset($_SESSION['habitaciones'][$numHabitacion])) {
                throw new InvalidArgumentException('Debes seleccionar una habitación válida.');
            }

            $id = count($_SESSION['reservas']) + 1;
            $reserva = new Reserva(
                $id,
                $_SESSION['huespedes'][$idHuesped],
                $_SESSION['habitaciones'][$numHabitacion],
                $noches
            );
            $_SESSION['reservas'][$id] = $reserva;
            $_SESSION['mensaje'] = 'Reserva #' . $id . ' realizada correctamente.';

        } elseif ($accion === 'cancelar_reserva') {
            $idReserva = (int) ($_POST['reserva'] ?? 0);

            if (!isset($_SESSION['reservas'][$idReserva])) {
                throw new InvalidArgumentException('La reserva no existe.');
            }
            if (!$_SESSION['reservas'][$idReserva]->activa) {
                throw new InvalidArgumentException('La reserva ya está cancelada.');
            }

            $_SESSION['reservas'][$idReserva]->cancelar();
            $_SESSION['mensaje'] = 'Reserva #' . $idReserva . ' cancelada.';
        }
    } catch (InvalidArgumentException $e) {
        $_SESSION['error'] = $e->getMessage();
    }


    header('Location: index.php');
    exit;
}


$mensaje = $_SESSION['mensaje'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['mensaje'], $_SESSION['error']);

$habitaciones = $_SESSION['habitaciones'];
$huespedes = $_SESSION['huespedes'];
$reservas = $_SESSION['reservas'];


$disponibles = [];
foreach ($habitaciones as $habitacion) {
    if ($habitacion->disponible) {
        $disponibles[] = $habitacion;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hotel Nocturna</title>
</head>
<body>
    <h1>Hotel Nocturna</h1>

    <?php if ($mensaje !== ''): ?>
        <p><strong>✔ <?= $mensaje ?></strong></p>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
        <p><strong>✘ <?= $error ?></strong></p>
    <?php endif; ?>

    <h2>Habitaciones</h2>
    <?php foreach ($habitaciones as $habitacion): ?>
        <?= $habitacion->obtenerHtml() ?>
    <?php endforeach; ?>

    <h2>Registrar huésped</h2>
    <form method="post" action="index.php">
        <input type="hidden" name="accion" value="registrar_huesped">
        <p>
            <label>Nombre de pila:
                <input type="text" name="nombre_pila" required>
            </label>
        </p>
        <p>
            <label>Apellidos:
                <input type="text" name="apellidos" required>
            </label>
        </p>
        <p>
            <label>Correo electrónico:
                <input type="email" name="email" required>
            </label>
        </p>
        <p>
            <label>Teléfono:
                <input type="text" name="telefono" required>
            </label>
        </p>
        <button type="submit">Registrar</button>
    </form>

    <h2>Huéspedes</h2>
    <?php if (count($huespedes) === 0): ?>
        <p>No hay huéspedes registrados.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo electrónico</th>
                <th>Teléfono</th>
            </tr>
            <?php foreach ($huespedes as $huesped): ?>
                <tr>
                    <td><?= $huesped->id ?></td>
                    <td><?= $huesped->nombre ?></td>
                    <td><?= $huesped->email ?></td>
                    <td><?= $huesped->telefono ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h2>Realizar reserva</h2>
    <?php if (count($huespedes) === 0): ?>
        <p>Primero debes registrar al menos un huésped.</p>
    <?php elseif (count($disponibles) === 0): ?>
        <p>No hay habitaciones disponibles.</p>
    <?php else: ?>
        <form method="post" action="index.php">
            <input type="hidden" name="accion" value="realizar_reserva">
            <p>
                <label>Huésped:
                    <select name="huesped">
                        <?php foreach ($huespedes as $huesped): ?>
                            <option value="<?= $huesped->id ?>">
                                <?= $huesped->nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </p>
            <p>
                <label>Habitación:
                    <select name="habitacion">
                        <?php foreach ($disponibles as $habitacion): ?>
                            <option value="<?= $habitacion->numero ?>">
                                <?= $habitacion->numero ?> — <?= $habitacion->nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </p>
            <p>
                <label>Noches:
                    <input type="number" name="noches" min="1" value="1" required>
                </label>
            </p>
            <button type="submit">Reservar</button>
        </form>
    <?php endif; ?>

    <h2>Reservas</h2>
    <?php if (count($reservas) === 0): ?>
        <p>No hay reservas realizadas.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Id</th>
                <th>Huésped</th>
                <th>Habitación</th>
                <th>Noches</th>
                <th>Importe</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= $reserva->id ?></td>
                    <td><?= $reserva->huesped->nombre ?></td>
                    <td>
                        <?= $reserva->habitacion->numero ?> —
                        <?= $reserva->habitacion->nombre ?>
                    </td>
                    <td><?= $reserva->noches ?></td>
                    <td><?= $reserva->calcularImporte() ?> €</td>
                    <td><?= $reserva->activa ? 'Activa' : 'Cancelada' ?></td>
                    <td>
                        <?php if ($reserva->activa): ?>
                            <form method="post" action="index.php">
                                <input type="hidden" name="accion" value="cancelar_reserva">
                                <input type="hidden" name="reserva" value="<?= $reserva->id ?>">
                                <button type="submit">Cancelar</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>