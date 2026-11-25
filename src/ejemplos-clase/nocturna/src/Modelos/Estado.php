<?php

    /**
     * Estados posibles de una habitación.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Modelos ;

    enum Estado: int {
        case OCUPADA     = 0 ;
        case DISPONIBLE  = 1 ;        
    }

   