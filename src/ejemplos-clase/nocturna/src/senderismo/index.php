<?php

    require __DIR__ . "/vendor/autoload.php" ;
    require_once __DIR__ . "/Config/Rutas.php" ;

    $accion = $_GET["accion"] ?? "ruta-indice" ;

    $parametros = array_filter($_GET, fn($clave) => strtolower($clave) != "accion", ARRAY_FILTER_USE_KEY) ;

    $control = RUTAS[$accion] ?? null ;

    if ($control === null):
        http_response_code(404) ;
        exit("Página no encontrada") ;
    endif ;

    [$clase, $metodo] = $control ;

    $controlador = new $clase ;

    $controlador->$metodo(...$parametros) ;
