<?php

    function calcularEstancia(float $precio, int $noches): float{
            return $precio * $noches;
        }


    function mostrarHabitaciones(array $habitaciones, ?int $seleccionada): void {
        foreach ($habitaciones as $h) {
            $disabled = ($h["Disponibilidad"] === "Disponible") ? '' : 'disabled';
            $checked  = ($seleccionada === $h["Numero"]) ? 'checked' : '';
            $nombre   = htmlspecialchars($h["Habitacion"]);

            echo "<tr>";
            echo "<td>{$h['Numero']}</td>";
            echo "<td>$nombre</td>";
            echo "<td>{$h['Precio']} €</td>";
            echo "<td>{$h['Capacidad']}</td>";
            echo "<td>{$h['Disponibilidad']}</td>";
            echo "<td><input type='radio' name='habitacion' value='{$h['Numero']}'
                    data-info='{$h['Numero']} — $nombre, {$h['Precio']} €/noche · Capacidad: {$h['Capacidad']} personas'
                    $checked $disabled></td>";
            echo "</tr>";
        }
    }
?>