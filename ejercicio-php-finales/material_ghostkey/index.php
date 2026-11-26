<?php

    session_start();

    require_once __DIR__ . "/Modelos/Credencial.php";
    require_once __DIR__ . "/Modelos/Usuario.php";

    $fallo= false;

    if(isset($_POST["usuario"])):

        $usuario = Usuario::autenticar(trim($_POST["usuario"]), $_POST["contra"] ?? "");

        if($usuario === null):
            $fallo= true;
        else:
            session_regenerate_id(true) ;
            $_SESSION["idUsuario"] = $usuario->idUsuario;
            $_SESSION["nombre"] = $usuario->nombre;
        endif;
    endif;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GhostKey</title>
</head>
<body>
    <header>
        <h2>GhostKey</h2>
    </header>
    <main>
        <div>
            <form action="index.php" method="post">
                <h4>Iniciar sesión</h4>
                <p>Accede a tu caja fuerte personal</p>
                <?php if ($fallo): ?>
                    <p>Usuario o contraseña incorrectos.</p>
                <?php endif; ?>
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" placeholder="Introduce tu usuario" required autofocus>
                <label for="contra">Contraseña</label>
                <input type="password" id="contra" name="contra" placeholder="Introduce tu contraseña" required>
                <button type="submit">Acceder</button>
            </form>
        </div>
    </main>
</body>
</html>