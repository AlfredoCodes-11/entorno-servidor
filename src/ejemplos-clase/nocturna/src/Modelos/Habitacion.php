<?php

    /**
     * Habitación del hotel: datos, precio de la estancia y presentación.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Modelos ;

    use Nocturna\Modelos\Estado ;
    
    class Habitacion {

        private int $idHabitacion ;
        public readonly int $numero ;
        public private(set) string $nombre ;                 
        public Estado $estado = Estado::DISPONIBLE {
            set(Estado|int $value) {
                $this->estado = is_int($value)?Estado::from($value):$value ;                                
            }
        } 

        // private int $idHabitacion ;

        // private int $estado ;

        /**
         * Número máximo de huéspedes. No puede ser menor que 1.
         */
        public int $capacidad {

            get => $this->capacidad ;
            set {

                if ($value < 1):
                    throw new \InvalidArgumentException("La habitación debe tener como mínimo un huésped.") ;
                else:
                    $this->capacidad = $value ;
                endif ;

            }

        }

        /**
         * Precio por noche. No puede ser negativo.
         */
        public float $precio {

            get => $this->precio ;
            set {
                if ($value < 0):
                    throw new \InvalidArgumentException("El precio por noche no puede ser negativo.") ;
                else :
                    $this->precio = $value ;
                endif ;
            }
        }    

        // public function estado() 
        // { ESTILO + ESTADO
            
        // }
                

        /**
         * Constructor vacío para poder hidratar el objeto desde la base de datos.
         */
        public function __construct() 
        {                     
        }

        /**
         * Asigna el número de la habitación.
         * @param int $numero Número de habitación
         * @return void
         */
        public function setNumero(int $numero): void
        {
            $this->numero = $numero ;
        }

        /**
         * Asigna el nombre de la habitación.
         * @param string $nombre Nombre visible de la habitación
         * @return void
         */
        public function setNombre(string $nombre): void
        {
            $this->nombre = $nombre ;
        }

        /**
         * Calcula el importe de la estancia, sin IVA.
         * @param int $noches Número de noches, al menos una
         * @return float Importe total de la estancia
         */
        public function calcularImporte(int $noches): float 
        {
            if ($noches < 1)
                throw new \InvalidArgumentException("La estancia debe ser de al menos una noche.") ;
            
            # Calculamos el precio (sin iva) si el número de noches es correcto
            return $this->precio * $noches ;
        }

        /**
         * Devuelve la habitación como una tarjeta HTML.
         * @return string Tarjeta con número, nombre, precio, capacidad y estado
         */
        public function __toString() : string 
        {
            # Definimos por defecto el estado/estilo para una habitación disponible
            $estado = "Disponible" ;
            $estilo = "bg-success" ;

            # Si está ocupada cambiamos el estado y estilo
            if ($this->estado == Estado::OCUPADA):
                $estado = "Ocupada" ;
                $estilo = "bg-danger" ;
            endif ;

            return "<div class=\"card\" style=\"width:32rem; background-color: #eee;    \">" .
                   "<div class=\"card-body\">" .
                   "<h2>Habitación {$this->numero} - {$this->nombre}</h2>" .
                   "<p><strong>Precio por noche</strong>: {$this->precio}€" .
                   "<p><strong>Capacidad</strong>: {$this->capacidad} huéspedes" .
                   "<p><strong>Estado</strong>: <span class=\"badge $estilo\">$estado</span>" .
                   "</div>" .
                   "</div>" ;

        }
        
        

    }