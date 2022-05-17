<?php
class Viaje
{
    private $destino;
    private $codigo;
    private $cantMaxPasajeros;
    private $responsable;
    private $importe;
    private $tipoAsiento;
    private $pasajeros;
    private $tipoViaje;


    /**
     * Constructor
     * @param string $destino
     * @param string $codigo
     * @param int $cantMaxPasajeros
     * @param object $responsable
     */
    public function __construct($destino, $codigo, $cantMaxPasajeros, $responsable, $importe, $tipoAsiento)
    {
        $this->destino = $destino;
        $this->codigo = $codigo;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = array();
        $this->responsable = $responsable;
        $this->importe = $importe;
        $this->tipoAsiento = $tipoAsiento;
        //IV = Ida y Vuelta
        if ($tipoAsiento ==  "IV") {
            $this->importe = $importe * 1.5;
        } else {
            $this->importe = $importe;
        }
    }

    //Getters
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

    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    public function getResponsable()
    {
        return $this->responsable;
    }

    public function getTipoViaje()
    {
        return $this->tipoViaje;
    }


    public function getTipoAsiento()
    {
        return $this->tipoAsiento;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    //Setters
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

    public function setPasajeros($pasajeros)
    {
        $this->pasajeros = $pasajeros;
    }

    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }

    public function setTipoViaje($tipoViaje)
    {
        $this->tipoViaje = $tipoViaje;
    }

    public function setTipoAsiento($tipoAsiento)
    {
        $this->tipoAsiento = $tipoAsiento;
    }

    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    // Métodos
    /**
     * Metodo que devuelve la lista de pasajeros en forma de string de la instancia actual de Viaje.
     * @return string
     */
    private function getStringPasajeros()
    {
        if (count($this->pasajeros) > 0) {
            $stringPasajeros = "Pasajeros: \nNombre Apellido DNI Telefono\n";
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
    public function hayPasajesDisponible()
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
        return "\nResponsable\n" . $this->getResponsable() .
            "\nDestino: " . $this->getDestino() .
            "\nCodigo: " . $this->getCodigo() .
            "\nCantidad maxima de pasajeros: " . $this->getCantMaxPasajeros() .
            "\n" . $this->getStringPasajeros();
    }

    public function __destruct()
    {
        return "Instancia de viaje a " . $this->getDestino() . " destruida.\n";
    }
}
