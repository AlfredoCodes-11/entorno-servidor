<?php

    /**
     * Construye una habitación a partir de los datos recibidos.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Factorias ;

    use Nocturna\Modelos\Habitacion;

    abstract class HabitacionFactory
    {
        /**
         * Crea una habitación y rellena sus datos.
         * @param array $datos Número, nombre, capacidad y precio
         * @return Habitacion Habitación construida
         */
        public static function crear(array $datos): Habitacion
        {
            $habitacion = new Habitacion ;
            $habitacion->setNumero( (int) $datos["numero"] ) ;
            $habitacion->setNombre( $datos["nombre"] ) ;
            $habitacion->capacidad = (int) $datos["capacidad"] ;
            $habitacion->precio = (float) $datos["precio"] ;            

            return $habitacion ;
        }

    }