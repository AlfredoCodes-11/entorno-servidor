<?php

    require_once __DIR__ . "/../Config/Database.php";

    class Credencial{

        public readonly int $idCredencial;
        public readonly int $idUsuario;
        public string $servicio;
        public string $url;
        public string $login;
        public string $clave;


        public function __construct(int $idUsuario, string $servicio, string $url, string $login, string $clave){
            $this->idUsuario = $idUsuario ;
            $this->servicio  = $servicio ;
            $this->url       = $url ;
            $this->login     = $login ;
            $this->clave     = $clave ;
        }

        public static function obtenerTodas(int $idUsuario):array{

            $sentencia = Database::obtenerInstancia()->ejecutar(
                "SELECT * FROM credencial WHERE idUsuario = :idUsuario ORDER BY servicio;",
                [":idUsuario" => $idUsuario]
            );

            $credenciales = [] ;

            foreach ($sentencia->fetchAll(\PDO::FETCH_ASSOC) as $fila):
                $credencial = new Credencial(
                    (int) $fila["idUsuario"],
                    $fila["servicio"],
                    $fila["url"],
                    $fila["login"],
                    $fila["clave"]
                ) ;
                $credencial->idCredencial = (int) $fila["idCredencial"] ;

                $credenciales[] = $credencial ;
            endforeach ;

            return $credenciales ;
        }


        public static function obtenerTotal(int $idUsuario): int{

                return count(self::obtenerTodas($idUsuario));

        }

        public static function obtenerPagina(int $idUsuario, int $numPag, int $numCreden):array{

            if ($numPag < 1) $numPag = 1 ;

            $sentencia = Database::obtenerInstancia()->ejecutar(
                "SELECT * FROM credencial WHERE idUsuario = :idUsuario " .
                "ORDER BY servicio, idCredencial LIMIT :limite OFFSET :desplazamiento ;",
                [
                    ":idUsuario"      => $idUsuario,
                    ":limite"         => $numCreden,
                    ":desplazamiento" => ($numPag - 1) * $numCreden,
                ]
            ) ;

            $credenciales = [] ;

            foreach ($sentencia->fetchAll(\PDO::FETCH_ASSOC) as $fila):
                $credencial = new Credencial(
                    (int) $fila["idUsuario"],
                    $fila["servicio"],
                    $fila["url"],
                    $fila["login"],
                    $fila["clave"]
                ) ;
                $credencial->idCredencial = (int) $fila["idCredencial"] ;

                $credenciales[] = $credencial ;
            endforeach ;

            return $credenciales ;

        }



    }


?>