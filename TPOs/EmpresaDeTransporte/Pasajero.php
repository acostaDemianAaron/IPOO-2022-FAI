<?php
class Pasajero {
    private $nombre;
    private $apellido;
    private $dni;

    // Constructor
    public function __construct($nombre, $apellido, $dni) {
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setDni($dni);
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

    // Funciones magicas
    public function __toString() {
        return "Nombre: " . $this->getNombre() . "\nApellido: " . $this->getApellido() . "\nDNI: " . $this->getDni();
    }

    public function __destruct() {
        echo "Se destruyo la instancia de Pasajero " . $this->getNombre() . "\n";
    }
}