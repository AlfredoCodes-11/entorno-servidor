<?php

    class Reserva {
        
        public private(set) bool $activa;
 
        public function __construct(
            public readonly int $id,
            public private(set) Huesped $huesped,
            public private(set) Habitacion $habitacion,
            public private(set) int $noches,
        ) {
            if (!$habitacion->disponible) {
                throw new InvalidArgumentException("La habitación no está disponible.");
            }
    
            if ($noches < 1) {
                throw new InvalidArgumentException("La estancia debe ser de al menos una noche.");
            }
    
            $habitacion->ocupar();
            $this->activa = true;
        }

        public function calcularImporte(): float
    {
        return $this->habitacion->calcularImporte($this->noches);
    }
 
    public function cancelar(): void
    {
        $this->activa = false;
        $this->habitacion->liberar();
    }

    }


?>