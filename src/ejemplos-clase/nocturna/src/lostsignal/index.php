<?php

    require_once __DIR__ . "/Senal.php" ;

    $estadoFiltro = $_GET["estado"] ?? "" ;
    $filtro       = null ;

    foreach (EstadoSenal::cases() as $caso):
        if ($caso->value == $estadoFiltro) $filtro = $caso ;
    endforeach ;

    if ($filtro === null):
        $senales      = Senal::obtenerTodas() ;
        $estadoFiltro = "" ;
    else:
        $senales = Senal::obtenerPorEstado($filtro) ;
    endif ;

    $resultado   = $_GET["resultado"] ?? "" ;
    $mensaje     = "" ;
    $tipoMensaje = "success" ;

    if ($resultado == "error"):
        $mensaje     = "No se ha podido analizar la señal." ;
        $tipoMensaje = "danger" ;
    elseif ($resultado == "registrada" || $resultado == "confirmada" || $resultado == "descartada"):
        $identificador = filter_input(INPUT_GET, "identificador", FILTER_VALIDATE_INT) ;
        $senalMensaje  = $identificador ? Senal::buscar($identificador) : null ;

        if ($senalMensaje !== null):
            $mensaje = "La señal {$senalMensaje->codigo} ha sido {$resultado} correctamente." ;
        endif ;
    endif ;

    $titulo = "Señales" ;
    require __DIR__ . "/cabecera.php" ;

?>
        <h1 class="h3 mb-4">Señales registradas</h1>

        <?php if ($mensaje !== ""): ?>
            <div class="alert alert-<?= $tipoMensaje ?>"><?= $mensaje ?></div>
        <?php endif; ?>

        <form action="index.php" method="get" class="row g-2 align-items-end mb-4">
            <div class="col-auto">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="">Todas las señales</option>
                    <?php foreach (EstadoSenal::cases() as $caso): ?>
                        <option value="<?= $caso->value ?>" <?= ($caso === $filtro) ? "selected" : "" ?>><?= $caso->descripcion() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Estación</th>
                    <th>Frecuencia (MHz)</th>
                    <th>Intensidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($senales) === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center text-secondary">No hay señales registradas.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($senales as $senal): ?>
                    <tr class="<?= $senal->prioritaria ? "table-warning" : "" ?>">
                        <td><?= $senal->codigo ?></td>
                        <td><?= $senal->estacion ?></td>
                        <td><?= $senal->frecuencia ?></td>
                        <td><?= $senal->intensidad ?></td>
                        <td><?= $senal->estado->descripcion() ?></td>
                        <td>
                            <?php if ($senal->estado === EstadoSenal::PENDIENTE): ?>
                                <form action="analizar.php" method="post" class="d-inline">
                                    <input type="hidden" name="identificador" value="<?= $senal->identificador ?>">
                                    <input type="hidden" name="estado" value="<?= $estadoFiltro ?>">
                                    <button type="submit" name="accion" value="confirmar" class="btn btn-success btn-sm">Confirmar</button>
                                    <button type="submit" name="accion" value="descartar" class="btn btn-danger btn-sm">Descartar</button>
                                </form>
                            <?php else: ?>
                                &mdash;
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<?php

    require __DIR__ . "/pie.php" ;
