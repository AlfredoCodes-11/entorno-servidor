<?php

    /**
     * Controlador del listado de habitaciones.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Controladores ;

    use Nocturna\Repositorios\HabitacionRepository ;
    use Nocturna\Modelos\Estado ;

    class HabitacionController extends BaseController
    {
        /**
         * Muestra el panel con todas las habitaciones.
         * @return void
         */
        public function indice(): void
        {
            $habitacionRepository = new HabitacionRepository ;
            $habitaciones = $habitacionRepository->getAll() ;

            $this->render("lista-habitaciones.html.twig", [ 
                    "habitaciones" => $habitaciones, 
             ]) ;
        }
    }