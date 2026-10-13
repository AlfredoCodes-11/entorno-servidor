<?php
	/**
	 * EJERCICIO 06 - CARRITO
	 * @author Antonio José Sánchez Bujaldón
	 */

	session_start() ;

	$catalogo = ["Cuaderno", "Bolígrafo", "Mochila", "Estuche", "Calculadora"] ;
	$accion = $_POST["accion"] ?? "" ;
	$producto = $_POST["producto"] ?? "" ;
	$elegidos = $_POST["productos"] ?? [] ;
	$error = "" ;

	if (!isset($_SESSION["carrito"])) :
		$_SESSION["carrito"] = [] ;
	endif ;

	if (!is_array($elegidos)) :
		$elegidos = [] ;
	endif ;

	if ($accion === "vaciar") :
		$_SESSION["carrito"] = [] ;
	elseif ($accion === "eliminar") :
		$carrito = [] ;

		foreach ($_SESSION["carrito"] as $item) :
			if ($item !== $producto) :
				$carrito[] = $item ;
			endif ;
		endforeach ;

		$_SESSION["carrito"] = $carrito ;
	elseif ($accion === "anadir") :
		if (count($elegidos) === 0) :
			$error = "Selecciona al menos un producto." ;
		else :
			foreach ($elegidos as $elegido) :
				if (in_array($elegido, $catalogo, true) and !in_array($elegido, $_SESSION["carrito"], true)) :
					$_SESSION["carrito"][] = $elegido ;
				endif ;
			endforeach ;
		endif ;
	endif ;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<title>Carrito</title>
</head>
<body>
	<form method="post">
		<label>
			Productos
			<select name="productos[]" multiple size="5" required>
				<?php foreach ($catalogo as $item) : ?>
					<option value="<?= $item ?>"><?= $item ?></option>
				<?php endforeach ; ?>
			</select>
		</label>
		<button type="submit" name="accion" value="anadir">Añadir al carrito</button>
	</form>

	<?php if (!empty($error)) : ?>
		<p><?= $error ?></p>
	<?php endif ; ?>

	<h2>Carrito</h2>

	<?php if (count($_SESSION["carrito"]) === 0) : ?>
		<p>El carrito está vacío.</p>
	<?php else : ?>
		<ul>
			<?php foreach ($_SESSION["carrito"] as $item) : ?>
				<li>
					<?= $item ?>
					<form method="post">
						<input type="hidden" name="producto" value="<?= $item ?>" />
						<button type="submit" name="accion" value="eliminar">Eliminar</button>
					</form>
				</li>
			<?php endforeach ; ?>
		</ul>
		<form method="post">
			<button type="submit" name="accion" value="vaciar">Vaciar carrito</button>
		</form>
	<?php endif ; ?>
</body>
</html>