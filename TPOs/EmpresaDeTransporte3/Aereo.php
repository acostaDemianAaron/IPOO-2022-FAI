<?php

class Aereo extends Viaje
{
    private $codigoVuelo;
    private $nomAereolinea;
    private $escala;

    //Constructor
    public function __construct($destino, $codigo, $cantMaxPasajeros, $responsable, $importe, $tipoAsiento, $codigoVuelo, $nomAereolinea, $escala)
    {
        parent::__construct($destino, $codigo, $cantMaxPasajeros, $responsable, $importe, $tipoAsiento);
        $this->codigoVuelo = $codigoVuelo;
        $this->nomAereolinea = $nomAereolinea;
        $this->escala = $escala;
    }

    //Getters
    public function getCodigoVuelo()
    {
        return $this->codigoVuelo;
    }

    public function getNomAereolinea()
    {
        return $this->nomAereolinea;
    }

    public function getEscala()
    {
        return $this->escala;
    }

    //Setters
    public function setCodigoVuelo($codigoVuelo)
    {
        $this->codigoVuelo = $codigoVuelo;
    }

    public function setNomAereolinea($nomAereolinea)
    {
        $this->nomAereolinea = $nomAereolinea;
    }

    public function setEscala($escala)
    {
        $this->escala = $escala;
    }

    //Metodos
    //Primera Clase = P y Estandar = E
    public function venderPasaje($pasajero, $tipoAsiento)
    {
        $importe = $this->getImporte();
        if ($tipoAsiento == "P" && $this->getEscala() == 0) {
            $importe = $importe * 1.4;
            $this->agregarPasajero($pasajero);
        } elseif ($tipoAsiento == "P" && $this->getEscala() > 0) {
            $importe = $importe * 1.6;
            $this->agregarPasajero($pasajero);
        } elseif ($tipoAsiento != "E") {
            echo "El tipo de asiento no es valido";
        }
        return $importe;
    }


    //ToString
    public function __toString()
    {
        return parent::__toString() . "Codigo de Vuelo: " . $this->getCodigoVuelo() . " Nombre de la Aereolinea: " . $this->getNomAereolinea() . " Escala: " . $this->getEscala();
    }
}
