<?php

    enum EstadoSenal: string
    {
        case PENDIENTE  = "P" ;
        case CONFIRMADA = "C" ;
        case DESCARTADA = "D" ;

        public function descripcion(): string
        {
            if ($this == self::PENDIENTE):
                return "Pendiente" ;
            elseif ($this == self::CONFIRMADA):
                return "Confirmada" ;
            else:
                return "Descartada" ;
            endif ;
        }
    }
