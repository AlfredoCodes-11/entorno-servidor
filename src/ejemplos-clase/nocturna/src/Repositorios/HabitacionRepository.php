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

        /**
         * Inserta una nueva habitación en la base de datos.
         * @param Habitacion $habitacion Habitación a guardar
         * @return bool true si se ha guardado
         */
        public function save(Habitacion $habitacion): bool
        {
            # Usamos una sentencia preparada: los datos nunca se pegan directamente en el SQL
            $resultado = $this->pdo->prepare(
                "INSERT INTO habitacion (numero, nombre, capacidad, precio, estado) " .
                "VALUES (:numero, :nombre, :capacidad, :precio, :estado)"
            ) ;

            return $resultado->execute([
                ":numero" => $habitacion->numero,
                ":nombre" => $habitacion->nombre,
                ":capacidad" => $habitacion->capacidad,
                ":precio" => $habitacion->precio,
                ":estado" => $habitacion->estado->value,
            ]) ;
        }



    }