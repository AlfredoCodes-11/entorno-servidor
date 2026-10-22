<?php
    function generarCodigo(): void
    {
        $_SESSION["codigo"] = random_int(1000, 9999);
        $_SESSION["intentos"] = 6;
        $_SESSION["estado"] = "jugando";
    }

    function comprobarCodigo(int $introducido): bool
    {
        return $introducido == $_SESSION["codigo"];
    }

    function generarPista(int $introducido): string
    {
        if ($introducido < $_SESSION["codigo"]):
            return "El código es MAYOR.";
        else:
            return "El código es MENOR.";
        endif;
    }

?>