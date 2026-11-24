<?php

    namespace Senderismo\Modelos ;

    class Ruta extends BaseModel
    {
        public const array DIFICULTADES = [ "baja", "media", "alta" ] ;

        public int $idRuta ;
        public string $nombre ;
        public string $localidad ;
        public float $distancia ;
        public int $desnivel ;
        public string $dificultad ;

        public static function todas(\PDO $db): array
        {
            $resultado = $db->query("SELECT * FROM ruta ORDER BY nombre ;") ;

            return $resultado->fetchAll(\PDO::FETCH_CLASS, self::class, [ $db ]) ;
        }

        public static function porDificultad(\PDO $db, string $dificultad): array
        {
            $sentencia = $db->prepare("SELECT * FROM ruta WHERE dificultad = :dificultad ORDER BY nombre ;") ;
            $sentencia->bindValue(":dificultad", $dificultad, \PDO::PARAM_STR) ;
            $sentencia->execute() ;

            return $sentencia->fetchAll(\PDO::FETCH_CLASS, self::class, [ $db ]) ;
        }

        public static function find(\PDO $db, int $id): ?self
        {
            $sentencia = $db->prepare("SELECT * FROM ruta WHERE idRuta = :id ;") ;
            $sentencia->bindValue(":id", $id, \PDO::PARAM_INT) ;
            $sentencia->execute() ;

            $ruta = $sentencia->fetchObject(self::class, [ $db ]) ;

            return $ruta ?: null ;
        }
    }
