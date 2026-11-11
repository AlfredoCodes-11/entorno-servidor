<?php

require_once 'EstadoHabitacion.php';
require_once 'Habitacion.php';
require_once 'Huesped.php';
require_once 'Reserva.php';

echo '<h1>Pruebas</h1>';

echo '<h2>Huéspedes</h2>';

$huespedes = [
    new Huesped(1, 'Vlad', 'Tepes', 'dracula@nocturna.com', '666 000 001'),
    new Huesped(2, 'Víctor', 'Frankenstein', 'frankenstein@nocturna.com', '666 000 002'),
    new Huesped(3, 'Morticia', 'Addams', 'morticia@nocturna.com', '666 000 003'),
    new Huesped(4, 'Larry', 'Talbot', 'hombrelobo@nocturna.com', '666 000 004'),
    new Huesped(5, 'Jack', 'Griffin', 'invisible@nocturna.com', '666 000 004'),
];

foreach ($huespedes as $huesped) {
    echo $huesped->obtenerHtml();
}

echo '<p>Total de huéspedes: ' . Huesped::getTotalHuespedes() . '</p>';

try {
    $huespedes[0]->nombre = 'Imhotep';
    echo '<p>ERROR: no se ha lanzado la excepción.</p>';
} catch (InvalidArgumentException $e) {
    echo '<p>Excepción capturada: ' . $e->getMessage() . '</p>';
}

$huespedes[0]->nombre = 'Conde Drácula';
echo '<p>Nombre de pila: ' . $huespedes[0]->nombrePila
    . ' | Apellidos: ' . $huespedes[0]->apellidos . '</p>';

echo '<h2>Habitaciones</h2>';

$habitaciones = [
    new Habitacion(13, 'Cripta real', 120, 2),
    new Habitacion(66, 'Laboratorio Frankenstein', 95, 3),
    new Habitacion(99, 'Sarcófago Imperial', 150, 2),
    new Habitacion(404, 'Suite Fantasmal', 80, 1),
    new Habitacion(666, 'Trono de Lucifer', 110, 2),
];

echo '<p>Ocupación inicial: ' . Habitacion::calcularOcupacion($habitaciones) . ' %</p>';

$habitaciones[0]->ocupar();
$habitaciones[1]->ponerEnMantenimiento();
echo '<p>Con 1 ocupada y 1 en mantenimiento: '
    . Habitacion::calcularOcupacion($habitaciones) . ' % (esperado: 20)</p>';

echo '<p>Array vacío: ' . Habitacion::calcularOcupacion([]) . ' % (esperado: 0)</p>';

try {
    $habitaciones[1]->ocupar();
    echo '<p>ERROR: no se ha lanzado la excepción.</p>';
} catch (InvalidArgumentException $e) {
    echo '<p>Excepción capturada: ' . $e->getMessage() . '</p>';
}

$habitaciones[1]->finalizarMantenimiento();
echo '<p>Estado del Laboratorio tras finalizar mantenimiento: '
    . $habitaciones[1]->estado->value . '</p>';

try {
    $habitaciones[0]->precioPorNoche = -5;
} catch (InvalidArgumentException $e) {
    echo '<p>Excepción capturada: ' . $e->getMessage() . '</p>';
}

try {
    $habitaciones[0]->calcularImporte(0);
} catch (InvalidArgumentException $e) {
    echo '<p>Excepción capturada: ' . $e->getMessage() . '</p>';
}

echo '<h2>Reservas</h2>';

$habitaciones[0]->liberar();
$reserva = new Reserva(1, $huespedes[0], $habitaciones[0], 3);
echo '<p>Importe de 3 noches: ' . $reserva->calcularImporte() . ' € (esperado: 360)</p>';
echo '<p>Estado de la habitación 13: ' . $habitaciones[0]->estado->value . '</p>';

try {
    new Reserva(2, $huespedes[1], $habitaciones[0], 2);
} catch (InvalidArgumentException $e) {
    echo '<p>Excepción capturada: ' . $e->getMessage() . '</p>';
}

try {
    new Reserva(3, $huespedes[1], $habitaciones[2], 0);
} catch (InvalidArgumentException $e) {
    echo '<p>Excepción capturada: ' . $e->getMessage() . '</p>';
}
echo '<p>La habitación 99 sigue en estado: ' . $habitaciones[2]->estado->value . ' (esperado: disponible)</p>';

$reserva->cancelar();
echo '<p>Tras cancelar, la habitación 13 está: ' . $habitaciones[0]->estado->value . '</p>';

try {
    $reserva->cancelar();
} catch (InvalidArgumentException $e) {
    echo '<p>Excepción capturada: ' . $e->getMessage() . '</p>';
}
