<?php

    function conectar(): PDO
    {
        try {
            $dsn = "mysql:host=db;dbname=lostsignal;charset=utf8" ;

            return new PDO($dsn, "root", "root") ;

        } catch (PDOException $pdoe) {
            die("**ERROR: " . $pdoe->getMessage()) ;
        }
    }
