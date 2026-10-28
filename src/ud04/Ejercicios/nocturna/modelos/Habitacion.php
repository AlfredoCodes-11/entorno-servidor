<?php

    class Habitacion {

        
        /**
         * 
         */
        public function __construct(public readonly int $numero,
                                public private(set) string $nombre,
                                public private(set) int $capacidad {
                                    set {
                                        if ($value <= 0){
                                            throw new InvalidArgumentException(
                                                "La capacidad máxima debe ser como mínimo de una persona."
                                            );
                                        }
                                        $this->capacidad = $value;
                                    }
                                },

                                public float $precio {
                                    set {
                                        if($value <= 0){
                                            throw new InvalidArgumentException(
                                                "El precio por noche debe ser mayor que cero."
                                            );
                                        }
                                        $this->precio = $value;
                                    }
                                },

                                public private(set) bool $disponible = true,
                                )
        {
        }

        /**
         */
        public function ocupar(): void
        {
            $this->disponible = false;
        }

        /**
         * 
         */
        public function liberar(): void
        {
            $this->disponible = true;
        }

        /**
         * 
         */
        public function calcularImporte(int $noches): float
        {
            if ($noches < 1) {
                throw new InvalidArgumentException(
                    "La estancia debe ser de al menos una noche."
                );
            }
    
            return $this->precio * $noches;
        }


    }
    







?>