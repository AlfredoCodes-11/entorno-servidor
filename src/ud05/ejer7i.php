<?
session_start();

$mensaje = "";
var_dump($_SESSION["numero"], $_POST["intento"]);
if (empty($_SESSION)) {

    $numero = rand(1, 100);

    $_SESSION["numero"] = $numero;
    $_SESSION["intentos"] = 0;
} elseif(isset($_POST["intento"])) {

    if ($_POST["intento"] == $_SESSION["numero"]) {
        $mensaje = "HAS GANADO, numero de intentos: ". $_SESSION["intentos"];

        $_SESSION = [];
        session_destroy();


    } else {

        if ($_POST["intento"] > $_SESSION["numero"]) {
            $mensaje = "El numero es menor. Intentalo de nuevo";
            $_SESSION["intentos"]++;
        } elseif ($_POST["intento"] < $_SESSION["numero"]) {

            $mensaje = "El numero es mayor. Intentalo de nuevo";
            $_SESSION["intentos"]++;
        }
    }
}else{
    $mensaje = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="7.php" method="post">

        Itroduce un numero del 1 al 100 <input type="number" name="intento" id="intento" min ="1" max = "100" required>
        <button>Enviar</button>
        <p><?= $mensaje ?></p>

    </form>
</body>

</html>