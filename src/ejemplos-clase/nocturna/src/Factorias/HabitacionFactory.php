<?php

    /**
     * Construye una habitación a partir de los datos recibidos.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Factorias ;

    use Nocturna\Modelos\Habitacion;
    use Nocturna\Modelos\Estado;

    abstract class HabitacionFactory
    {
        /**
         * Crea una habitación y rellena sus datos.
         * @param array $datos Número, nombre, capacidad, precio y, opcionalmente, estado
         * @return Habitacion Habitación construida
         * @throws \InvalidArgumentException Si falta algún dato o no es válido
         */
        public static function crear(array $datos): Habitacion
        {
            # Comprobamos que llegan todos los campos obligatorios
            foreach (["numero", "nombre", "capacidad", "precio"] as $campo):
                if (trim($datos[$campo] ?? "") === "")
                    throw new \InvalidArgumentException("Falta el campo \"$campo\".") ;
            endforeach ;

            if ((int) $datos["numero"] < 1)
                throw new \InvalidArgumentException("El número de habitación debe ser mayor que cero.") ;

            $habitacion = new Habitacion ;
            $habitacion->setNumero( (int) $datos["numero"] ) ;
            $habitacion->setNombre( trim($datos["nombre"]) ) ;
            $habitacion->capacidad = (int) $datos["capacidad"] ;
            $habitacion->precio = (float) $datos["precio"] ;

            # El estado es opcional: si no llega, la habitación queda disponible
            if (isset($datos["estado"])):
                $estado = Estado::tryFrom( (int) $datos["estado"] ) ;
                if ($estado === null)
                    throw new \InvalidArgumentException("El estado indicado no es válido.") ;
                $habitacion->estado = $estado ;
            endif ;

            return $habitacion ;
        }

    }
