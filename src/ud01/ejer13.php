<?php

    $clase = [ 
        "profesores" => ["Pedro Pérez", "Gema Gómez"],
        "cursos" => ["Biología", "Química"],
    ];

    echo "<pre>". print_r($clase, true). "</pre>";

    $clase["cursos"][0] = "Física";

    echo "<pre>". print_r($clase, true). "</pre>";
    