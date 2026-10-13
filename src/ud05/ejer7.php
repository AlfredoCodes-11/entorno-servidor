<?php

    session_start();

    $numero_jugador = $_POST["numero_introducido"]??"";
    $mensaje = "";

    if ((!isset($_SESSION["numero"])) or (isset($_POST["nueva"]))){
        $_SESSION["numero"] = rand(1,100);
        $_SESSION["intentos"] = 0;
        $fin = false;
    }

        if ((!empty($_POST)) and (!isset($_POST["nueva"])) and (!$fin)) {

            if (($numero_jugador < 1) or ($numero_jugador > 100)) {
                $mensaje = "El número deber ser entre 1 y 100.";
            } else {
                $_SESSION["intentos"] = $_SESSION["intentos"] + 1;
                $valor = $numero_jugador;

                if ($valor < $_SESSION["numero"]){
                    $mensaje = "El número es mayor";
                } elseif ($valor > $_SESSION["numero"]) {
                    $mensaje = "El número es menor";
                } else {
                    $fin = true;
                }
            }
        }

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 07</title>
</head>
<body>
    <?php if ($fin == true) : ?>
		<p>Has acertado en <?= $_SESSION["intentos"] ?> intentos.</p>
		<form method="post">
			<button type="submit" name="nueva" value="1">Nueva partida</button>
		</form>
	<?php else : ?>
		<p>Intentos: <?= $_SESSION["intentos"] ?></p>
		<form method="post">
			<label>
				Número
				<input type="number" name="numero" min="1" max="100" step="1" required />
			</label>
			<button type="submit">Probar</button>
		</form>

		<?php if (!empty($mensaje)) : ?>
			<p><?= $mensaje ?></p>
		<?php endif ; ?>
	<?php endif ; ?>
</body>
</html>