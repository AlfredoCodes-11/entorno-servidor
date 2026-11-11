<?php

require_once 'EstadoHabitacion.php';
require_once 'Habitacion.php';
require_once 'Huesped.php';
require_once 'Reserva.php';

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
            $digitos = str_replace(' ', '', $telefono);
            if (!is_numeric($digitos) || strlen($digitos) < 9) {
                throw new InvalidArgumentException('El teléfono debe ser numérico y tener al menos 9 dígitos.');
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
    if ($habitacion->estado === EstadoHabitacion::DISPONIBLE) {
        $disponibles[] = $habitacion;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Nocturna</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>Hotel Nocturna</h1>
        <nav>
            <a href="#habitaciones">Habitaciones</a>
            <a href="#huespedes">Huéspedes</a>
            <a href="#reservas">Reservas</a>
        </nav>
    </header>

    <main>
        <?php if ($mensaje !== ''): ?>
            <div class="mensaje"><?= $mensaje ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <section id="habitaciones">
            <h2>Habitaciones</h2>
            <div class="habitaciones">
                <?php foreach ($habitaciones as $habitacion): ?>
                    <?= $habitacion->obtenerHtml() ?>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="huespedes">
            <h2>Huéspedes</h2>

            <h3>Registrar huésped</h3>
            <form method="post" action="index.php">
                <input type="hidden" name="accion" value="registrar_huesped">
                <p>
                    <label>Nombre de pila
                        <input type="text" name="nombre_pila" required>
                    </label>
                </p>
                <p>
                    <label>Apellidos
                        <input type="text" name="apellidos" required>
                    </label>
                </p>
                <p>
                    <label>Correo electrónico
                        <input type="email" name="email" required>
                    </label>
                </p>
                <p>
                    <label>Teléfono
                        <input type="text" name="telefono" required>
                    </label>
                </p>
                <button type="submit">Registrar</button>
            </form>

            <h3>Listado de huéspedes</h3>
            <?php if (count($huespedes) === 0): ?>
                <p>No hay huéspedes registrados.</p>
            <?php else: ?>
                <div class="tabla">
                    <table>
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
                </div>
            <?php endif; ?>
        </section>

        <section id="reservas">
            <h2>Reservas</h2>

            <h3>Nueva reserva</h3>
            <?php if (count($huespedes) === 0): ?>
                <p>Primero debes registrar al menos un huésped.</p>
            <?php elseif (count($disponibles) === 0): ?>
                <p>No hay habitaciones disponibles.</p>
            <?php else: ?>
                <form method="post" action="index.php">
                    <input type="hidden" name="accion" value="realizar_reserva">
                    <p>
                        <label>Huésped
                            <select name="huesped">
                                <?php foreach ($huespedes as $huesped): ?>
                                    <option value="<?= $huesped->id ?>"><?= $huesped->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </p>
                    <p>
                        <label>Habitación
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
                        <label>Número de noches
                            <input type="number" name="noches" min="1" value="1" required>
                        </label>
                    </p>
                    <button type="submit">Reservar</button>
                </form>
            <?php endif; ?>

            <h3>Listado de reservas</h3>
            <?php if (count($reservas) === 0): ?>
                <p>No hay reservas realizadas.</p>
            <?php else: ?>
                <div class="tabla">
                    <table>
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
                                <td><?= $reserva->habitacion->numero ?> — <?= $reserva->habitacion->nombre ?></td>
                                <td><?= $reserva->noches ?></td>
                                <td><?= $reserva->calcularImporte() ?> €</td>
                                <td>
                                    <?php if ($reserva->activa): ?>
                                        <span class="disponible">Activa</span>
                                    <?php else: ?>
                                        <span class="ocupada">Cancelada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($reserva->activa): ?>
                                        <form method="post" action="index.php">
                                            <input type="hidden" name="accion" value="cancelar_reserva">
                                            <input type="hidden" name="reserva" value="<?= $reserva->id ?>">
                                            <button type="submit" class="cancelar">Cancelar</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        Hotel Nocturna · Gestión de reservas
    </footer>
</body>
</html>
