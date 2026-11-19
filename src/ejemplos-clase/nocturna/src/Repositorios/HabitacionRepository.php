<?php

    /**
     * Acceso a las habitaciones almacenadas en la base de datos.
     * @author Antonio José Sánchez Bujaldón
     */

    namespace  Nocturna\Repositorios ;
    
    use Nocturna\Config\Database ;
    use Nocturna\Modelos\Habitacion ;

    class HabitacionRepository
    {

        private \PDO $pdo ;

        /**
         * Obtiene la conexión PDO compartida.
         */
        public function __construct()
        {
            $this->pdo = Database::conexion() ;
        }
        
        /**
         * Recupera todas las habitaciones de la base de datos.
         * @return Habitacion[] Listado de habitaciones
         */
        public function getAll(): array
        {            
            $resultado = $this->pdo->query("SELECT * FROM habitacion ;") ;

            return $resultado->fetchAll(\PDO::FETCH_CLASS, Habitacion::class) ;
        }



    }