<?php

    use Senderismo\Controladores\RutaController ;

    const RUTAS = [
        "ruta-indice"  => [ RutaController::class, "indice" ],
        "ruta-filtrar" => [ RutaController::class, "filtrar" ],
        "ruta-ver"     => [ RutaController::class, "ver" ],
    ] ;
