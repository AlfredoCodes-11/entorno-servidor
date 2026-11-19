<?php

    /**
     * Punto de entrada de la aplicación. Actúa como controlador frontal del modelo MVC.
     * @author Antonio José Sánchez Bujaldón
     */

    require __DIR__ . "/vendor/autoload.php" ;

    use Nocturna\Controladores\HabitacionController ;

    $controlador = new HabitacionController ;
    $controlador->indice() ;