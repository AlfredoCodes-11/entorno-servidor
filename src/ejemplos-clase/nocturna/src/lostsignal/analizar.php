<?php

    require_once __DIR__ . "/Senal.php" ;

    if (!isset($_POST["identificador"])):
        header("Location: index.php") ;
        exit ;
    endif ;

    $identificador = filter_input(INPUT_POST, "identificador", FILTER_VALIDATE_INT) ;
    $accion        = $_POST["accion"] ?? "" ;
    $estadoFiltro  = $_POST["estado"] ?? "" ;

    $destino = "index.php?resultado=error" ;

    try {

        $senal = $identificador ? Senal::buscar($identificador) : null ;

        if ($senal !== null):
            if ($accion == "confirmar" && $senal->confirmar()):
                $destino = "index.php?resultado=confirmada&identificador={$senal->identificador}" ;
            elseif ($accion == "descartar" && $senal->descartar()):
                $destino = "index.php?resultado=descartada&identificador={$senal->identificador}" ;
            endif ;
        endif ;

    } catch (PDOException $pdoe) {
        $destino = "index.php?resultado=error" ;
    }

    foreach (EstadoSenal::cases() as $caso):
        if ($caso->value == $estadoFiltro) $destino .= "&estado={$caso->value}" ;
    endforeach ;

    header("Location: $destino") ;
    exit ;
