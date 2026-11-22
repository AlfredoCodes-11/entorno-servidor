<?php

    /**
     * Controlador de las habitaciones: listado y alta.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Controladores ;

    use Nocturna\Repositorios\HabitacionRepository ;
    use Nocturna\Factorias\HabitacionFactory ;
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

        /**
         * Muestra el formulario para dar de alta una habitación.
         * @return void
         */
        public function nueva(): void
        {
            # El formulario aparece vacío y sin errores
            $this->render("nueva-habitacion.html.twig", [
                    "datos" => [],
                    "error" => null,
             ]) ;
        }

        /**
         * Recibe los datos del formulario, crea la habitación y la guarda.
         * Si todo va bien vuelve al panel; si no, muestra de nuevo el formulario con el error.
         * @return void
         */
        public function guardar(): void
        {
            # Solo aceptamos datos enviados por POST desde el formulario
            if ($_SERVER["REQUEST_METHOD"] !== "POST"):
                header("Location: index.php?accion=nueva") ;
                exit ;
            endif ;

            try {

                # La factoría construye la habitación; el modelo valida precio y capacidad
                $habitacion = HabitacionFactory::crear($_POST) ;

                $habitacionRepository = new HabitacionRepository ;
                $habitacionRepository->save($habitacion) ;

                # Redirigimos al panel para que al recargar no se vuelva a enviar el formulario
                header("Location: index.php") ;
                exit ;

            } catch (\InvalidArgumentException $iae) {
                $error = $iae->getMessage() ;

            } catch (\PDOException $pdoe) {
                # 1062: clave duplicada (el número de habitación es UNIQUE)
                if (($pdoe->errorInfo[1] ?? null) == 1062):
                    $error = "Ya existe una habitación con el número {$_POST["numero"]}." ;
                else:
                    $error = "No se pudo guardar la habitación en la base de datos." ;
                endif ;
            }

            # Volvemos a mostrar el formulario con lo que escribió el usuario y el error
            $this->render("nueva-habitacion.html.twig", [
                    "datos" => $_POST,
                    "error" => $error,
             ]) ;
        }
    }
