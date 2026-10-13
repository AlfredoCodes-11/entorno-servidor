<?php
	/**
	 * EJERCICIO 07 - ADIVINA EL NÚMERO
	 * @author Antonio José Sánchez Bujaldón
	 */

	session_start() ;

	$numero = trim($_POST["numero"] ?? "") ;
	$mensaje = "" ;

	if (!isset($_SESSION["secreto"]) or isset($_POST["nueva"])) :
		$_SESSION["secreto"] = rand(1, 100) ;
		$_SESSION["intentos"] = 0 ;
		unset($_SESSION["fin"]) ;
	endif ;

	if (!empty($_POST) and !isset($_POST["nueva"]) and empty($_SESSION["fin"])) :
		if (!ctype_digit($numero) or (int) $numero < 1 or (int) $numero > 100) :
			$mensaje = "Introduce un número entre 1 y 100." ;
		else :
			$_SESSION["intentos"] = $_SESSION["intentos"] + 1 ;
			$valor = (int) $numero ;

			if ($valor < $_SESSION["secreto"]) :
				$mensaje = "mayor" ;
			elseif ($valor > $_SESSION["secreto"]) :
				$mensaje = "menor" ;
			else :
				$_SESSION["fin"] = true ;
			endif ;
		endif ;
	endif ;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<title>Adivina el número</title>
</head>
<body>
	<?php if (!empty($_SESSION["fin"])) : ?>
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