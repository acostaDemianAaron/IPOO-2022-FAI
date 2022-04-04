<?php
class Viaje
{
    private $destino;
    private $codigo;
    private $cantMaxPasajeros;
    private $pasajeros;

    // Constructor
    public function __construct($destino, $codigo, $cantMaxPasajeros)
    {
        $this->setDestino($destino);
        $this->setCodigo($codigo);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->pasajeros = array();
    }

    // Setter
    private function setDestino($destino)
    {
        $this->destino = $destino;
    }

    private function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    private function setCantMaxPasajeros($cantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    private function setPasajero($pasajero)
    {
        $nuevoPasajero = ["Nombre" => $pasajero->getNombre(), "Apellido" => $pasajero->getApellido(), "DNI" => $pasajero->getDni()];
        array_push($this->pasajeros, $nuevoPasajero);
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

    /**
     * Metodo que convierte el array de pasajero en un String
     * @return
     */
    public function getStringPasajeros()
    {
        if (count($this->pasajeros) > 0) {
            $stringPasajeros = "\n";
            foreach ($this->pasajeros as $pasajero) {
                $stringPasajeros = $stringPasajeros . "\t" . $pasajero["Nombre"] . " " . $pasajero["Apellido"] . " " . $pasajero["DNI"] . "\n";
            }
        } else {
            $stringPasajeros = "No hay pasajeros en el viaje";
        }
        return $stringPasajeros;
    }
    // Métodos
    // Esta funcion sirve para agregar pasajeros
    public function agregarPasajero($pasajero)
    {
        if (count($this->pasajeros) < $this->cantMaxPasajeros) {
            $this->setPasajero($pasajero);
        }
    }

    // Este funcion retorna TRUE si el pasajero existe, en caso contrario retorna FALSE
    private function existePasajero($dni)
    {
        foreach ($this->pasajeros as $pasajero) {
            if ($pasajero["DNI"] == $dni) {
                return true;
            }
        }
        return false;
    }

    //Esta funcion hace un recorrido exhaustivo para buscar y eliminar un pasajero
    public function eliminarPasajero($dni)
    {
        if ($this->existePasajero($dni)) {
            foreach ($this->pasajeros as $key => $pasajero) {
                if ($pasajero["DNI"] == $dni) {
                    unset($this->pasajeros[$key]);
                }
            }
            time_nanosleep(0, 300000000);
            echo "\n\t◢ ================================================◣\n";
            echo "\t    Se ha eliminado el pasajero de DNI: " . $dni . "\n";
            echo "\t◥ ================================================◤\n\n";
            time_nanosleep(0, 500000000);
        } else {
            time_nanosleep(0, 300000000);
            echo "\n\t◢ ========================◣\n";
            echo "\t‖ No existe el pasajero   ‖\n";
            echo "\t◥ ========================◤\n\n";
            time_nanosleep(0, 500000000);
        }
    }

    //Esta funcion verifica si el viejo tiene capacidad para agregar un pasajero.
    public function hayCapacidad()
    {
        return count($this->pasajeros) < $this->cantMaxPasajeros;
    }

    // Funciones magicas
    public function __toString()
    {
        return "\n◢=====================================◣\n" .
            "|Destino: {$this->getDestino()}\t\t\t\n" .
            "|Codigo: {$this->getCodigo()}\t\t\t\n" .
            "|Cantidad maxima de pasajeros: {$this->getCantMaxPasajeros()}\t\n" .
            "◥======================================◤\n" .
            "Pasajeros: {$this->getStringPasajeros()}\n";
    }

    public function __destruct()
    {
        echo "Instancia de viaje a " . $this->getDestino() . " destruida.\n";
    }
}
