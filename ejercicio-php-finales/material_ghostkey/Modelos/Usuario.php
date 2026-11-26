<?php

    require_once __DIR__ . "/../Config/Database.php";

    class Usuario{

        public readonly int $idUsuario;
        public readonly string $nombre;
        public readonly string $login;

        public function __construct(string $nombre = "", string $login = "")
        {
            if (!isset($this->nombre)) $this->nombre = $nombre ;
            if (!isset($this->login))  $this->login  = $login ;
        }

        public static function autenticar(string $login, string $contrasena) : ?Usuario{

            $hash = Database::obtenerInstancia()->ejecutar(
                "SELECT contrasena FROM usuario WHERE login = :login;",
                [":login" => $login]
            )->fetchColumn();

            if ($hash === false || !password_verify($contrasena, $hash)) return null;

            $usuario = Database::obtenerInstancia()->ejecutar(
                "SELECT idUsuario, nombre, login FROM usuario WHERE login = :login;",
                [":login" => $login]
            )->fetchObject(Usuario::class);

            return $usuario ?: null;

        }

    }


?>