<?php

    /**
     * Punto de entrada de la aplicación. Actúa como controlador frontal del modelo MVC.
     * @author Antonio José Sánchez Bujaldón
     */

    require __DIR__ . "/vendor/autoload.php" ;

    use Nocturna\Controladores\HabitacionController ;

    $controlador = new HabitacionController ;

    # La acción llega por la URL (index.php?accion=...). Si no hay, mostramos el panel.
    $accion = $_GET["accion"] ?? "indice" ;

    match ($accion) {
        "nueva"   => $controlador->nueva(),      // muestra el formulario de alta
        "guardar" => $controlador->guardar(),    // recibe el formulario y guarda la habitación
        default   => $controlador->indice(),     // panel de habitaciones
    } ;
