<?php

$estudiante = ["nombre" => "Ana",
                "edad"  => 22,
                "curso" => "Matemáticas"];

print_r($estudiante);

echo "<br/>";

echo "<strong>Alumno/a: </strong> {$estudiante["nombre"]}<br/>
      <strong>Edad: </strong> {$estudiante["edad"]}<br/>
      <strong>Curso: </strong/> {$estudiante["curso"]}<br/>";

    // echo "<strong>Alumno/a: </strong>";
    // print_r($estudiante["nombre"]);
    // echo "<br/>";
    // echo "<strong>Edad: </strong/>";
    // print_r($estudiante["edad"]);
    // echo "<br/>";
    // echo "<strong>Curso: </strong/>";
    // print_r($estudiante["curso"]);
?>