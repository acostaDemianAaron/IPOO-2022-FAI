<?php
class Viaje
{
    private $destino;
    private $codigo;
    private $cantMaxPasajeros;
    private $pasajeros;
    private $responsable;

    /**
     * Constructor
     * @param string $destino
     * @param string $codigo
     * @param int $cantMaxPasajeros
     * @param object $responsable
     */
    public function __construct($destino, $codigo, $cantMaxPasajeros, $responsable)
    {
        $this->destino = $destino;
        $this->codigo = $codigo;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = array();
        $this->responsable = $responsable;
    }

    // Setter
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function setPasajeros($pasajero)
    {
        $this->pasajeros = $pasajero;
    }

    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }

    // Getter
    public function getDestino()
    {
        return $this->destino;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getCantMaxPasajeros()
    {
        return $this->cantMaxPasajeros;
    }

    public function getResposable()
    {
        return $this->responsable;
    }

    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    // Métodos
    /**
     * Metodo que devuelve la lista de pasajeros en forma de string de la instancia actual de Viaje.
     * @return string
     */
    private function getStringPasajeros()
    {
        if (count($this->pasajeros) > 0) {
            $stringPasajeros = "Pasajeros: \nNombre Apellido DNI\n";
            foreach ($this->pasajeros as $pasajero) {
                $stringPasajeros = $stringPasajeros . $pasajero->getNombre() . 
                " " . $pasajero->getApellido() . " " . $pasajero->getDni() . 
                " " . $pasajero->getTelefono() . "\n";
            }
        } else {
            $stringPasajeros = "No hay pasajeros en el viaje";
        }
        return $stringPasajeros;
    }

    /**
     * Metodo que devuelve si hay capacidad para agregar un pasajero a la instancia actual de Viaje.
     */
    public function hayCapacidad()
    {
        return count($this->pasajeros) < $this->cantMaxPasajeros;
    }

    /**
     * Metodo que agrega un pasajero a la instancia actual de Viaje.
     * @param object $pasajero
     */
    public function agregarPasajero($pasajero)
    {
        $coleccion = $this->getPasajeros();
        array_push($coleccion, $pasajero);
        $this->setPasajeros($coleccion);
    }

    /**
     * Metodo que comprueba la existencia de un pasajero en la instancia actual de Viaje.
     * @param string $dni
     * @return bool
     */
    public function existePasajero($dni)
    {
        foreach ($this->pasajeros as $pasajero) {
            if ($pasajero->getDni() == $dni) {
                return true;
            }
        }
        return false;
    }

    /**
     * Metodo que elimina un pasajero buscandolo por su dni en la instancia actual de Viaje.
     * @param string $dni
     */
    public function eliminarPasajero($dni)
    {
        if ($this->existePasajero($dni)) {
            foreach ($this->pasajeros as $key => $pasajero) {
                if ($pasajero->getDni() == $dni) {
                    unset($this->pasajeros[$key]);
                }
            }
            echo "Se ha eliminado el pasajero de DNI: " . $dni . "\n";
        } else {
            echo "No existe el pasajero.\n";
        }
    }

    // Funciones magicas
    public function __toString()
    {
        return "\n+=======================================+" .
            "\nResponsable\n" . $this->getResposable() . 
            "\nDestino: " . $this->getDestino() .
            "\nCodigo: " . $this->getCodigo() .
            "\nCantidad maxima de pasajeros: " . $this->getCantMaxPasajeros() .
            "\n" . $this->getStringPasajeros() .
            "\n+=======================================+\n";
    }

    public function __destruct()
    {
        return "Instancia de viaje a " . $this->getDestino() . " destruida.\n";
    }
}
