<?php


    class Database {

        private static ?Database $instancia = null;
        private \PDO $conexion;
        public private(set) int $consultas = 0;


        private function __construct(){

            try {
                $dsn = "mysql:host=db;dbname=ghostkey;charset=utf8"; 

                $this->conexion = new \PDO ($dsn, "root", "root");
            } catch(\PDOException $pdoe){
                throw new \RuntimeException("ERROR: No se pudo establecer una conexión con la base de datos.");
            }
        }

        private function __clone() {}


        public static function obtenerInstancia() : Database{

            if ( self::$instancia == null ) self::$instancia = new self() ;
            return self::$instancia  ;

        }


        public function ejecutar(string $sql, ?array $array = null) : \PDOStatement{

            $sentencia = $this->conexion->prepare($sql);
            
            if ($array != null):
                foreach($array as $clave => $valor):
                    $tipo = match(true) {
                        is_int($valor) => PDO::PARAM_INT,
                        is_bool($valor) => PDO::PARAM_BOOL,
                        is_null($valor) => PDO::PARAM_NULL,
                        default => PDO::PARAM_STR,
                    };

                    $sentencia->bindValue($clave, $valor, $tipo);

                endforeach;
            endif;

            if($sentencia->execute()):
                $this->consultas++;
            endif;

            return $sentencia;
    
        }


    }


?>