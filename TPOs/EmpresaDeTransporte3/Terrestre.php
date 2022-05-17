<?php

class Terrestre extends Viaje
{
    public function __construct($destino, $codigo, $cantMaxPasajeros, $responsable, $importe, $tipoAsiento)
    {
        parent::__construct($destino, $codigo, $cantMaxPasajeros, $responsable, $importe, $tipoAsiento);
    }

    //Gettes
    public function getComodidadAsiento()
    {
        return $this->comodidadAsiento;
    }

    //Setters
    public function setComodidadAsiento($comodidadAsiento)
    {
        $this->comodidadAsiento = $comodidadAsiento;
    }

    //Metodos
    //Asiento Cama = C y Estandar = E
    public function venderPasajeTerrestre($comodidadAsiento)
    {
        $importe = $this->getImporte();
        if ($comodidadAsiento == "C") {
            $importe = $importe * 1.4;
        } else if ($comodidadAsiento != "SC") {
            echo "El tipo de asiento no es valido";
        }

        return $importe;
    }
}
