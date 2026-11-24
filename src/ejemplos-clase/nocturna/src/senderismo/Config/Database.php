<?php

    namespace Senderismo\Config ;

    class Database
    {
        private const string DATABASE_NAME = "senderismo" ;
        private const string DATABASE_USER = "root" ;
        private const string DATABASE_PASS = "root" ;

        private \PDO $pdo ;
        private static ?Database $instancia = null ;

        private function __construct()
        {
            try {
                $dsn = "mysql:host=db;dbname=" . self::DATABASE_NAME . ";charset=utf8" ;

                $this->pdo = new \PDO($dsn, self::DATABASE_USER, self::DATABASE_PASS) ;

            } catch (\PDOException $pdoe) {
                throw new \RuntimeException("**ERROR: No se pudo establecer una conexión con la base de datos.") ;
            }
        }

        private function __clone()
        {
        }

        public static function conexion(): \PDO
        {
            if (self::$instancia == null) self::$instancia = new self() ;
            return self::$instancia->pdo ;
        }
    }
