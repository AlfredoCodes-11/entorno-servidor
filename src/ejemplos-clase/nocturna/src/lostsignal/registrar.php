<?php

    require_once __DIR__ . "/Senal.php" ;

    $codigo     = "" ;
    $estacion   = "" ;
    $frecuencia = "" ;
    $intensidad = "" ;
    $error      = "" ;

    if (isset($_POST["codigo"])):

        $codigo     = trim($_POST["codigo"]) ;
        $estacion   = trim($_POST["estacion"] ?? "") ;
        $frecuencia = trim($_POST["frecuencia"] ?? "") ;
        $intensidad = trim($_POST["intensidad"] ?? "") ;

        $intensidadValida = filter_var($intensidad, FILTER_VALIDATE_INT) ;

        if ($codigo === ""):
            $error = "El código es obligatorio." ;
        elseif ($estacion === ""):
            $error = "La estación es obligatoria." ;
        elseif (!is_numeric($frecuencia)):
            $error = "La frecuencia debe ser un número." ;
        elseif ($intensidadValida === false):
            $error = "La intensidad debe ser un número entero." ;
        else:

            foreach (Senal::obtenerTodas() as $senalExistente):
                if ($senalExistente->codigo == $codigo) $error = "Ya existe una señal con el código {$codigo}." ;
            endforeach ;

            if ($error === ""):

                try {

                    $senal = new Senal($codigo, $estacion, (float) $frecuencia, $intensidadValida) ;
                    $senal->guardar() ;

                    header("Location: index.php?resultado=registrada&identificador={$senal->identificador}") ;
                    exit ;

                } catch (InvalidArgumentException $iae) {
                    $error = $iae->getMessage() ;

                } catch (PDOException $pdoe) {
                    $error = "No se ha podido registrar la señal. Comprueba que el código no esté repetido." ;
                }

            endif ;

        endif ;

    endif ;

    $titulo = "Registrar señal" ;
    require __DIR__ . "/cabecera.php" ;

?>
        <h1 class="h3 mb-4">Registrar señal</h1>

        <?php if ($error !== ""): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="registrar.php" method="post" class="col-md-6">
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control"
                       required maxlength="10" pattern="[A-Za-z0-9]+" value="<?= $codigo ?>">
            </div>
            <div class="mb-3">
                <label for="estacion" class="form-label">Estación</label>
                <input type="text" name="estacion" id="estacion" class="form-control"
                       required maxlength="50" value="<?= $estacion ?>">
            </div>
            <div class="mb-3">
                <label for="frecuencia" class="form-label">Frecuencia (MHz)</label>
                <input type="number" name="frecuencia" id="frecuencia" class="form-control"
                       required min="0.001" step="0.001" value="<?= $frecuencia ?>">
            </div>
            <div class="mb-3">
                <label for="intensidad" class="form-label">Intensidad</label>
                <input type="number" name="intensidad" id="intensidad" class="form-control"
                       required min="1" max="100" value="<?= $intensidad ?>">
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
<?php

    require __DIR__ . "/pie.php" ;
