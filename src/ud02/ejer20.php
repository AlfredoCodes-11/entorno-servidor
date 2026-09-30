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

                switch ($i) {
                    case $trampa:
                        echo "<td>💥</td>";
                        break;
                    case $cofre:
                        echo "<td>🔒</td>";
                        break;
                    case $diamante:
                        echo "<td>💎</td>";
                        break;
                    case $llave:
                        echo "<td>🔑</td>";
                        break;
                    default:
                        echo "<td>$i</td>";
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