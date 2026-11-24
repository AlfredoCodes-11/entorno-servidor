<?php

    namespace Senderismo\Controladores ;

    use Twig\Environment ;
    use Twig\Loader\FilesystemLoader ;

    abstract class BaseController
    {
        private Environment $twig ;

        public function __construct()
        {
            $loader     = new FilesystemLoader(__DIR__ . "/../Vistas") ;
            $this->twig = new Environment($loader, [ "autoescape" => "html", "strict_variables" => true ]) ;
        }

        public function render(string $plantilla, array $datos = []): void
        {
            echo $this->twig->render($plantilla, $datos) ;
        }
    }
