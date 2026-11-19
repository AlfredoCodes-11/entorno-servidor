<?php

    /**
     * Conexión única con la base de datos del hotel.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace Nocturna\Config ;

    /**
     * Garantiza una única conexión PDO durante la petición.
     * La clase guarda su propia instancia y la reutiliza.
     */
    class Database 
    {
        private const string DATABASE_NAME = "nocturna" ;
        private const string DATABASE_USER = "root" ;
        private const string DATABASE_PASS = "root" ;

        # Necesitaremos la librería PDO (PHP DATA OBJECT)
        # La implementación descansa sobre un objeto de clase PDO
        private \PDO $pdo ;
        private static ?Database $instancia = null ;    // instancia de la clase Database

        /**
         * Abre la conexión PDO con MySQL.
         */
        private function __construct()
        {
            try {
                # Data Source Name
                # Comprende una serie de propiedades y valores que dependen del
                # motor de bases de datos que vayamos a utilizar (mysql, pgsql, 
                # sqli, ...).
                $dsn = "mysql:host=db;dbname=" . self::DATABASE_NAME . ";charset=utf8"  ;

                # Establecemos la conexión con la base de datos creando un objeto PDO
                $this->pdo = new \PDO( $dsn, self::DATABASE_USER, self::DATABASE_PASS) ;

            } catch(\PDOException $pdoe) {
                throw new \RuntimeException("**ERROR: No se pudo establecer una conexión con la base de datos.") ;
            }
        }

        /**
         * Cierra la conexión con la base de datos.
         */
        public function __destruct()
        {
            $pdo = null ;
        }

        /**
         * Impide clonar la instancia.
         * @return void
         */
        private function __clone()
        {            
        }


        /**
         * Devuelve la conexión activa, creándola si todavía no existe.
         * @return \PDO Conexión con la base de datos
         */
        public static function conexion() : \PDO
        {
            if ( self::$instancia == null ) self::$instancia = new self() ;
            return self::$instancia->pdo  ;
        }

    }