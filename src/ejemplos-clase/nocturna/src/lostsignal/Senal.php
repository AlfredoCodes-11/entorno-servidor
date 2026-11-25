<?php

    require_once __DIR__ . "/conexion.php" ;
    require_once __DIR__ . "/EstadoSenal.php" ;

    class Senal
    {
        public private(set) ?int $identificador ;

        public readonly string $codigo ;

        public string $estacion ;

        public float $frecuencia {
            set {
                if ($value <= 0)
                    throw new InvalidArgumentException("La frecuencia debe ser superior a cero.") ;

                $this->frecuencia = $value ;
            }
        }

        public int $intensidad {
            set {
                if ($value < 1 || $value > 100)
                    throw new InvalidArgumentException("La intensidad debe estar comprendida entre 1 y 100.") ;

                $this->intensidad = $value ;
            }
        }

        public private(set) EstadoSenal $estado ;

        public bool $prioritaria {
            get => $this->intensidad >= 80 && $this->estado === EstadoSenal::PENDIENTE ;
        }

        public function __construct(
            string $codigo,
            string $estacion,
            float $frecuencia,
            int $intensidad,
            EstadoSenal $estado = EstadoSenal::PENDIENTE,
            ?int $identificador = null
        ) {
            $this->codigo        = $codigo ;
            $this->estacion      = $estacion ;
            $this->frecuencia    = $frecuencia ;
            $this->intensidad    = $intensidad ;
            $this->estado        = $estado ;
            $this->identificador = $identificador ;
        }

        private static function hidratar(array $fila): Senal
        {
            return new Senal(
                $fila["codigo"],
                $fila["estacion"],
                (float) $fila["frecuencia"],
                (int) $fila["intensidad"],
                EstadoSenal::from($fila["estado"]),
                (int) $fila["identificador"]
            ) ;
        }

        public static function obtenerTodas(): array
        {
            $resultado = conectar()->query("SELECT * FROM senal ORDER BY intensidad DESC ;") ;

            $senales = [] ;
            foreach ($resultado->fetchAll(PDO::FETCH_ASSOC) as $fila):
                $senales[] = self::hidratar($fila) ;
            endforeach ;

            return $senales ;
        }

        public function guardar(): void
        {
            $pdo = conectar() ;

            if ($this->identificador === null):
                $sentencia = $pdo->prepare(
                    "INSERT INTO senal (codigo, estacion, frecuencia, intensidad, estado) " .
                    "VALUES (:codigo, :estacion, :frecuencia, :intensidad, :estado) ;"
                ) ;
            else:
                $sentencia = $pdo->prepare(
                    "UPDATE senal SET codigo = :codigo, estacion = :estacion, frecuencia = :frecuencia, " .
                    "intensidad = :intensidad, estado = :estado WHERE identificador = :identificador ;"
                ) ;
                $sentencia->bindValue(":identificador", $this->identificador, PDO::PARAM_INT) ;
            endif ;

            $sentencia->bindValue(":codigo", $this->codigo, PDO::PARAM_STR) ;
            $sentencia->bindValue(":estacion", $this->estacion, PDO::PARAM_STR) ;
            $sentencia->bindValue(":frecuencia", $this->frecuencia, PDO::PARAM_STR) ;
            $sentencia->bindValue(":intensidad", $this->intensidad, PDO::PARAM_INT) ;
            $sentencia->bindValue(":estado", $this->estado->value, PDO::PARAM_STR) ;
            $sentencia->execute() ;

            if ($this->identificador === null):
                $this->identificador = (int) $pdo->lastInsertId() ;
            endif ;
        }

        public static function buscar(int $identificador): ?Senal
        {
            $sentencia = conectar()->prepare("SELECT * FROM senal WHERE identificador = :identificador ;") ;
            $sentencia->bindValue(":identificador", $identificador, PDO::PARAM_INT) ;
            $sentencia->execute() ;

            $fila = $sentencia->fetch(PDO::FETCH_ASSOC) ;

            return ($fila === false) ? null : self::hidratar($fila) ;
        }

        public function confirmar(): bool
        {
            return $this->analizar(EstadoSenal::CONFIRMADA) ;
        }

        public function descartar(): bool
        {
            return $this->analizar(EstadoSenal::DESCARTADA) ;
        }

        private function analizar(EstadoSenal $nuevoEstado): bool
        {
            if ($this->identificador === null || $this->estado !== EstadoSenal::PENDIENTE):
                return false ;
            endif ;

            $this->estado = $nuevoEstado ;
            $this->guardar() ;

            return true ;
        }

        public static function obtenerPorEstado(EstadoSenal $estado): array
        {
            $sentencia = conectar()->prepare("SELECT * FROM senal WHERE estado = :estado ORDER BY intensidad DESC ;") ;
            $sentencia->bindValue(":estado", $estado->value, PDO::PARAM_STR) ;
            $sentencia->execute() ;

            $senales = [] ;
            foreach ($sentencia->fetchAll(PDO::FETCH_ASSOC) as $fila):
                $senales[] = self::hidratar($fila) ;
            endforeach ;

            return $senales ;
        }
    }
