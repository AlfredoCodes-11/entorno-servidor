<?php

class Habitacion
{
    public private(set) EstadoHabitacion $estado = EstadoHabitacion::DISPONIBLE;

    public function __construct(
        public readonly int $numero,
        public private(set) string $nombre,
        public float $precioPorNoche = 100.0 {
            set {
                if ($value <= 0) {
                    throw new InvalidArgumentException(
                        "El precio por noche debe ser mayor que cero."
                    );
                }
                $this->precioPorNoche = $value;
            }
        },
        public private(set) int $capacidad = 1 {
            set {
                if ($value < 1) {
                    throw new InvalidArgumentException(
                        "La capacidad máxima debe ser como mínimo de una persona."
                    );
                }
                $this->capacidad = $value;
            }
        },
    ) {
    }

    public function ocupar(): void
    {
        if ($this->estado !== EstadoHabitacion::DISPONIBLE) {
            throw new InvalidArgumentException(
                "Solo se puede ocupar una habitación que esté disponible."
            );
        }
        $this->estado = EstadoHabitacion::OCUPADA;
    }

    public function liberar(): void
    {
        if ($this->estado !== EstadoHabitacion::OCUPADA) {
            throw new InvalidArgumentException(
                "Solo se puede liberar una habitación que esté ocupada."
            );
        }
        $this->estado = EstadoHabitacion::DISPONIBLE;
    }

    public function ponerEnMantenimiento(): void
    {
        if ($this->estado !== EstadoHabitacion::DISPONIBLE) {
            throw new InvalidArgumentException(
                "Solo se puede poner en mantenimiento una habitación que esté disponible."
            );
        }
        $this->estado = EstadoHabitacion::MANTENIMIENTO;
    }

    public function finalizarMantenimiento(): void
    {
        if ($this->estado !== EstadoHabitacion::MANTENIMIENTO) {
            throw new InvalidArgumentException(
                "La habitación no está en mantenimiento."
            );
        }
        $this->estado = EstadoHabitacion::DISPONIBLE;
    }

    public function calcularImporte(int $noches): float
    {
        if ($noches < 1) {
            throw new InvalidArgumentException(
                "La estancia debe ser de al menos una noche."
            );
        }

        return $this->precioPorNoche * $noches;
    }

    public static function calcularOcupacion(array $habitaciones): float
    {
        $total = count($habitaciones);

        if ($total === 0) {
            return 0;
        }

        $ocupadas = 0;
        foreach ($habitaciones as $habitacion) {
            if ($habitacion->estado === EstadoHabitacion::OCUPADA) {
                $ocupadas++;
            }
        }

        return $ocupadas / $total * 100;
    }

    public function obtenerHtml(): string
    {
        $html  = '<article>';
        $html .= '<h2>Habitación ' . $this->numero . ' — ' . $this->nombre . '</h2>';
        $html .= '<dl>';
        $html .= '<dt>Precio por noche:</dt><dd>' . $this->precioPorNoche . ' €</dd>';
        $html .= '<dt>Capacidad:</dt><dd>' . $this->capacidad . ' huéspedes</dd>';
        $html .= '<dt>Estado:</dt><dd><span class="' . $this->estado->value . '">' . $this->estado->value . '</span></dd>';
        $html .= '</dl>';
        $html .= '</article>';

        return $html;
    }
}
