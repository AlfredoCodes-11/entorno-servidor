<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 20</title>
    <style>
        table {border: 1px solid #000; border-collapse: collapse;}
        td {padding: 5px; text-aling:center; font-weight:bold; border: 1px solid #000;}
        .par {color:#fcba03;}
        .impar {color:#0317fc;}
        .fondo-par {color:#fcba03; background-color:#918f8e;}
        .fondo-impar {color:#0317fc;background-color:#918f8e;}
    </style>
</head>
<body>
    <table>
        <tbody>
            <tr>
        <?php
            $trampa = random_int(1,100);

            do {
                $cofre = random_int(1,100);
            } while ($cofre==$trampa);

            do {
                $diamante = random_int(1,100);
            } while ($diamante==$trampa || $diamante==$cofre);

            do {
                $llave = random_int(1,100);
            } while ($llave==$trampa || $llave==$cofre || $llave==$diamante);

             
        
            $filas=1;
            for($i = 1; $i <= 100; $i++):
                $valor = str_pad($i, 3, "0", STR_PAD_LEFT);

                switch ($i) {
                    case $trampa:
                        if ($filas%2==0){
                            echo "<td class=\"" . (($i%2==0)?"fondo-par":"impar") . "\">💥</td>\n";
                        }else{
                            echo "<td class=\"" . (($i%2==0)?"par":"fondo-impar") . "\">💥</td>\n";
                        }
                        break;
                    case $cofre:
                        if ($filas%2==0){
                            echo "<td class=\"" . (($i%2==0)?"fondo-par":"impar") . "\">🔒</td>\n";
                        }else{
                            echo "<td class=\"" . (($i%2==0)?"par":"fondo-impar") . "\">🔒</td>\n";
                        }
                        break;
                    case $diamante:
                        if ($filas%2==0){
                            echo "<td class=\"" . (($i%2==0)?"fondo-par":"impar") . "\">💎</td>\n";
                        }else{
                            echo "<td class=\"" . (($i%2==0)?"par":"fondo-impar") . "\">💎</td>\n";
                        }
                        break;
                    case $llave:
                        if ($filas%2==0){
                            echo "<td class=\"" . (($i%2==0)?"fondo-par":"impar") . "\">🔑</td>\n";
                        }else{
                            echo "<td class=\"" . (($i%2==0)?"par":"fondo-impar") . "\">🔑</td>\n";
                        }
                        break;
                    default:
                        if ($filas%2==0){
                    
                            echo "<td class=\"" . (($i%2==0)?"fondo-par":"impar") . "\">$valor</td>\n";
                        }else{
                        echo "<td class=\"" . (($i%2==0)?"par":"fondo-impar") . "\">$valor</td>\n";
                        }
                        break;
                }
                    
                //echo "<td class=\"" . (($i%2==0)?"par":"impar") . "\">$valor</td>\n";

                if ($i%10==0 && $i<91){
                    echo "</tr><tr>\n";
                    $filas++;
                }

            endfor;
        ?>
        </tr>
        </tbody>

        </table>

</body>
</html>