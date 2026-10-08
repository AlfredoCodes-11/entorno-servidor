<?php
    $ahora = date("d/m/Y H:i:s");

    if (isset($_COOKIE["ultima_visita"])) {
        $anterior = $_COOKIE["ultima_visita"];
    } else {
        $anterior = "";
    }

    setcookie("ultima_visita", $ahora);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 04</title>
</head>

<body>

    <?php if ($anterior == ""): ?>
        <p>Esta es tu primera visita.</p>
    <?php else: ?>
        <p>Tu última visita fue el <?= $anterior ?>.</p>
    <?php endif; ?>
</body>

</html>