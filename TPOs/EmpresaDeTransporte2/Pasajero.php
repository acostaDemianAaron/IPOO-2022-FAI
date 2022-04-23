<?php
class Pasajero {
    private $nombre;
    private $apellido;
    private $dni;
    private $telefono;

    /**
     * Constructor
     * @param string $nombrePersona
     * @param string $apellidoPersona
     * @param int $dniPersona
     * @param int $telefonoPersona
     */
    public function __construct($nombrePersona, $apellidoPersona, $dniPersona, $telefonoPersona) {
        $this->nombre = $nombrePersona;
        $this->apellido = $apellidoPersona;
        $this->dni = $dniPersona;
        $this->telefono = $telefonoPersona;
    }

    // Setter
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    // Getter
    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    // Funciones magicas
    public function __toString() {
        return "Nombre: " . $this->getNombre() . 
                "\nApellido: " . $this->getApellido() . 
                "\nDNI: " . $this->getDni() . 
                "\nTelefono: " . $this->getTelefono();
    }

    public function __destruct() {
        return "Se destruyo la instancia de Pasajero " . $this->getNombre() . "\n";
    }
}