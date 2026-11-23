<?php

    require_once __DIR__ . "/funciones.php" ;

    $pdo = conectar() ;

    $resultados = null ;
    $busqueda = "" ;
    $error = "" ;
    $id = "" ;
    $texto = "" ;

    if (isset($_GET["id"])):

        $id = trim($_GET["id"]) ;
        $idValido = filter_var($id, FILTER_VALIDATE_INT) ;

        if ($idValido === false || $idValido < 1):
            $error = "El identificador debe ser un número entero mayor que cero." ;
        else:
            $objeto = buscarPorIdentificador($pdo, $idValido) ;
            $resultados = ($objeto === false) ? [] : [ $objeto ] ;
            $busqueda = "con el identificador {$idValido}" ;
        endif ;

    elseif (isset($_GET["texto"])):

        $texto = trim($_GET["texto"]) ;

        if ($texto === ""):
            $error = "Escribe parte del nombre o de la descripción del objeto." ;
        else:
            $resultados = buscarPorTexto($pdo, $texto) ;
            $busqueda = "para la búsqueda \"{$texto}\"" ;
        endif ;

    endif ;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Oficina de objetos perdidos</title>
</head>
<body>

    <header>
        <h1>Oficina de objetos perdidos</h1>
    </header>

    <main>

        <div class="formularios">

            <form action="index.php" method="get">
                <h2>Buscar por identificador</h2>
                <input type="number" name="id" value="<?= $id ?>">
                <button type="submit">Buscar</button>
            </form>

            <form action="index.php" method="get">
                <h2>Buscar por nombre o descripción</h2>
                <input type="text" name="texto" value="<?= $texto ?>">
                <button type="submit">Buscar</button>
            </form>

        </div>

        <?php if ($error !== ""): ?>
            <p class="aviso error"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($resultados !== null): ?>

            <?php if (count($resultados) === 0): ?>
                <p class="aviso info">No se ha encontrado ningún objeto <?= $busqueda ?>.</p>

            <?php else: ?>
                <p><strong><?= count($resultados) ?></strong> objeto(s) encontrado(s) <?= $busqueda ?></p>

                <table border="1">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Lugar</th>
                            <th>Fecha de recogida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $objeto): ?>
                            <tr>
                                <td><?= $objeto["idObjeto"] ?></td>
                                <td><?= $objeto["nombre"] ?></td>
                                <td><?= $objeto["descripcion"] ?></td>
                                <td><?= $objeto["lugar"] ?></td>
                                <td><?= $objeto["fecha"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php endif; ?>

    </main>

</body>
</html>
