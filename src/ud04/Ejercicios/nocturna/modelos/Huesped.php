<?php

    class Huesped {


        public function __construct(
        public readonly int $id,
        public private(set) string $nombrePila,
        public private(set) string $apellidos,
        public private(set) string $email,
        public private(set) string $telefono,
        ) {
        }
 
    public string $nombre {
        get => $this->nombrePila . ' ' . $this->apellidos;
        set {
            $nombreCompleto = trim($value);
            $posicion = strpos($nombreCompleto, ' ');
 
            if ($posicion === false) {
                throw new InvalidArgumentException(
                    "El nombre debe contener al menos un nombre de pila y un apellido."
                );
            }
 
            $this->nombrePila = substr($nombreCompleto, 0, $posicion);
            $this->apellidos = trim(substr($nombreCompleto, $posicion + 1));
        }
    }

    public function obtenerHtml(): string
    {
        $nombre = ($this->nombre);
        $telefono = ($this->telefono);
 
        $html  = '<div>';
        $html .= '<h2>Huésped #' . $this->id . ' — ' . $nombre . '</h2>';
        $html .= '<dl>';
        $html .= '<dt>Nombre:</dt><dd>' . $nombre . '</dd>';
        $html .= '<dt>Teléfono:</dt><dd>' . $telefono . '</dd>';
        $html .= '</dl>';
        $html .= '</div>';
 
        return $html;
    }

    }

?>