<?php

    function conectar(): PDO
    {
        try {
            $dsn = "mysql:host=db;dbname=objetos_perdidos;charset=utf8" ;
            $pdo = new PDO($dsn, "root", "root") ;

            return $pdo ;

        } catch (PDOException $pdoe) {
            die("**ERROR: " . $pdoe->getMessage()) ;
        }
    }

    function buscarPorIdentificador(PDO $pdo, int $id): array|false
    {
        $sentencia = $pdo->prepare("SELECT * FROM objeto WHERE idObjeto = :id ;") ;
        $sentencia->bindValue(":id", $id, PDO::PARAM_INT) ;
        $sentencia->execute() ;

        return $sentencia->fetch(PDO::FETCH_ASSOC) ;
    }

    function buscarPorTexto(PDO $pdo, string $texto): array
    {
        $sentencia = $pdo->prepare("SELECT * FROM objeto WHERE nombre LIKE :nombre OR descripcion LIKE :descripcion ;") ;
        $sentencia->bindValue(":nombre", "%$texto%", PDO::PARAM_STR) ;
        $sentencia->bindValue(":descripcion", "%$texto%", PDO::PARAM_STR) ;
        $sentencia->execute() ;

        return $sentencia->fetchAll(PDO::FETCH_ASSOC) ;
    }
