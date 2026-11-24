<?php

    namespace Senderismo\Controladores ;

    use Senderismo\Config\Database ;
    use Senderismo\Modelos\Ruta ;

    class RutaController extends BaseController
    {
        public function indice(): void
        {
            $rutas = Ruta::todas(Database::conexion()) ;

            $this->render("listado-rutas.html.twig", [
                "rutas"        => $rutas,
                "dificultades" => Ruta::DIFICULTADES,
                "dificultad"   => "",
            ]) ;
        }

        public function filtrar(string $dificultad = ""): void
        {
            if (!in_array($dificultad, Ruta::DIFICULTADES)):
                $this->indice() ;
                return ;
            endif ;

            $rutas = Ruta::porDificultad(Database::conexion(), $dificultad) ;

            $this->render("listado-rutas.html.twig", [
                "rutas"        => $rutas,
                "dificultades" => Ruta::DIFICULTADES,
                "dificultad"   => $dificultad,
            ]) ;
        }

        public function ver(string $id = ""): void
        {
            $idValido = filter_var($id, FILTER_VALIDATE_INT) ;

            $ruta = ($idValido === false) ? null : Ruta::find(Database::conexion(), $idValido) ;

            if ($ruta === null):
                http_response_code(404) ;
            endif ;

            $this->render("detalle-ruta.html.twig", [
                "ruta" => $ruta,
            ]) ;
        }
    }
