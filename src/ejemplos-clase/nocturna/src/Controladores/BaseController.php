<?php

    /**
     * Controlador base. Prepara Twig para renderizar las vistas.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Controladores ;

    use \Twig\Environment ;
    use \Twig\Loader\FilesystemLoader ;

    abstract class BaseController
    {
        private Environment $twig ;        

        /**
         * Carga Twig apuntando a la carpeta de vistas.
         */
        public function __construct() 
        {
            require_once __DIR__ . "/../vendor/autoload.php" ;

            $loader     = new FilesystemLoader(__DIR__ . "/../Vistas") ;
            $this->twig = new Environment($loader, [ "autoescape" => "html", "strict_variables" => true ]) ;

        }

        /**
         * Pinta una plantilla Twig con los datos indicados.
         * @param string $plantilla Nombre del archivo de la vista
         * @param array $datos Variables disponibles en la plantilla
         * @return void
         */
        public function render(string $plantilla, array $datos = []): void
        {
            echo $this->twig->render($plantilla, $datos) ;
        }

    }