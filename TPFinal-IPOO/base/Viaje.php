<?php

class viaje
{
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $empresa; // Object
    private $responsable; // Object
    private $vimporte;
    private $tipoAsiento;
    private $idayvuelta;
    private $pasajeros; // Array [Objects]
    private $mensajeDeOperacion;

    //Construct
    public function __construct()
    {
        $this->idviaje;
        $this->vdestino;
        $this->vcantmaxpasajeros;
        $this->empresa;
        $this->responsable;
        $this->vimporte;
        $this->tipoAsiento;
        $this->idayvuelta;
        $this->pasajeros;
    }

    //Getters
    public function getIdviaje()
    {
        return $this->idviaje;
    }

    public function getVdestino()
    {
        return $this->vdestino;
    }

    public function getVcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function getResponsable()
    {
        return $this->responsable;
    }

    public function getVimporte()
    {
        return $this->vimporte;
    }

    public function getTipoAsiento()
    {
        return $this->tipoAsiento;
    }

    public function getIdayvuelta()
    {
        return $this->idayvuelta;
    }

    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    public function getMensajeDeOperacion()
    {
        return $this->mensajeDeOperacion;
    }

    //Setters
    public function setIdviaje($idviaje)
    {
        $this->idviaje = $idviaje;

        return $this;
    }

    public function setVdestino($vdestino)
    {
        $this->vdestino = $vdestino;

        return $this;
    }

    public function setVcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;

        return $this;
    }

    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function setVimporte($vimporte)
    {
        $this->vimporte = $vimporte;

        return $this;
    }

    public function setTipoAsiento($tipoAsiento)
    {
        $this->tipoAsiento = $tipoAsiento;

        return $this;
    }

    public function setIdayvuelta($idayvuelta)
    {
        $this->idayvuelta = $idayvuelta;

        return $this;
    }

    public function setPasajeros($pasajeros)
    {
        $this->pasajeros = $pasajeros;

        return $this;
    }

    public function setMensajeDeOperacion($mensajeDeOperacion)
    {
        $this->mensajeDeOperacion = $mensajeDeOperacion;

        return $this;
    }

    //Funciones Magicas
    //Cargar Datos
    public function cargarDatos($idviaje, $vdestino, $vcantmaxpasajeros, $empresa, $responsable, $vimporte, $tipoAsiento, $idayvuelta)
    {
        $this->idviaje = $idviaje;
        $this->vdestino = $vdestino;
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
        $this->empresa = $empresa;
        $this->responsable = $responsable;
        $this->vimporte = $vimporte;
        $this->tipoAsiento = $tipoAsiento;
        $this->idayvuelta = $idayvuelta;
    }

    //Buscar Datos
    public function buscarDatos($id, $factor)
    {
        $baseD = new BaseDatos();
        $empresa = new Empresa();
        $responsable = new ResponsableV();
        $pasajero = new Pasajero();
        $resultado = false;
        $consultaViaje = "SELECT * FROM viaje WHERE ";
        if ($factor == null) {
            $consultaViaje = $consultaViaje . 'idviaje = ' . $id;
        } else {
            $consultaViaje = $consultaViaje . $factor;
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaViaje)) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setIdViaje($aux['idviaje']);
                    $this->setVdestino($aux['vdestino']);
                    $this->setVcantmaxpasajeros($aux['vcantmaxpasajeros']);
                    $empresa->buscarDatos($aux['idempresa']);
                    $this->setEmpresa($empresa);
                    $responsable->buscarDatos($aux['rnumeroempleado']);
                    $this->setResponsable($responsable);
                    $this->setVimporte($aux['vimporte']);
                    $this->setTipoAsiento($aux['tipoAsiento']);
                    $this->setIdaYVuelta($aux['idayvuelta']);
                    $this->setPasajeros($pasajero->lista(" idviaje = " . $this->getIdViaje()));
                    $resultado = true;
                }
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $resultado;
    }

    //Coleccion De Viajes
    public function lista($factor = "")
    {
        $coleccionViaje = null;
        $baseD = new BaseDatos();
        $empresa = new Empresa();
        $responsable = new ResponsableV();

        $consultaViaje = "SELECT * FROM viaje ";
        if ($factor != "") {
            $consultaViaje = $consultaViaje . ' where ' . $factor;
        }
        $consultaViaje .= " order by idviaje ";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaViaje)) {
                $coleccionViaje = [];
                while ($aux = $baseD->registroConsulta()) {
                    $idviaje = $aux['idviaje'];
                    $vdestino = $aux['vdestino'];
                    $vcantmaxpasajeros = $aux['vcantmaxpasajeros'];
                    $empresa->buscarDatos($aux['idempresa']);
                    $responsable->buscarDatos($aux['rnumeroempleado']);
                    $vimporte = $aux['vimporte'];
                    $tipoAsiento = $aux['tipoAsiento'];
                    $idayvuelta = $aux['idayvuelta'];
                    $viaje = new Viaje();
                    $viaje->cargarDatos($idviaje, $vdestino, $vcantmaxpasajeros, $empresa, $responsable, $vimporte, $tipoAsiento, $idayvuelta);
                    array_push($coleccionViaje, $viaje);
                }
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $coleccionViaje;
    }

    //Insetar Datos
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $empresa = $this->getEmpresa();
        $responsable = $this->getResponsable();
        $resultado = false;
        if ($this->getIdviaje() == null) {
            $consultaViaje = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta) 
                    VALUES ('" . $this->getVdestino() . "','" .
                $this->getVcantmaxpasajeros() .  "','" .
                $empresa->getEmpresa() .  "','" .
                $responsable->getNumeroEmpleado() .  "','" .
                $this->getVimporte() .  "','" .
                $this->getTipoAsiento() .  "','" .
                $this->getIdaYVuelta() .  "')";
        } else {
            $consultaViaje = "INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta)
                    VALUES ('" . $this->getIdViaje() . "','" .
                $this->getVdestino() . "','" .
                $this->getVcantmaxpasajeros() .  "','" .
                $empresa->getIdempresa() .  "','" .
                $responsable->getRnumeroEmpleado() .  "','" .
                $this->getVimporte() .  "','" .
                $this->getTipoAsiento() .  "','" .
                $this->getIdaYVuelta() .  "')";
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaViaje)) {
                $resultado = true;
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $resultado;
    }

    //Modificar Datos
    public function modificarDatos($id = "")
    {
        $baseD = new BaseDatos();
        $resultado = false;
        $empresa = $this->getEmpresa();
        $responsable = $this->getResponsable();
        if ($id == null) {
            $consultaModificar = "UPDATE viaje 
            SET vdestino = '" . $this->getVdestino() .
                "', vcantmaxpasajeros = '" . $this->getVcantmaxpasajeros() .
                "', idempresa = '" . $empresa->getIdempresa() .
                "', rnumeroempleado = '" . $responsable->getNumeroEmpleado() .
                "', vimporte = '" . $this->getVimporte() .
                "', tipoAsiento = '" . $this->getTipoAsiento() .
                "', idayvuelta = '" . $this->getIdaYVuelta() .
                "' WHERE idviaje = " . $this->getIdViaje();
        } else {
            $consultaModificar = "";
            $consultaModificar = "UPDATE viaje 
            SET idviaje = '" . $this->getIdViaje() .
                "', vdestino = '" . $this->getVdestino() .
                "', vcantmaxpasajeros = '" . $this->getVcantmaxpasajeros() .
                "', idempresa = '" . $empresa->getIdempresa() .
                "', rnumeroempleado = '" . $responsable->getNumeroEmpleado() .
                "', vimporte = '" . $this->getVimporte() .
                "', tipoAsiento = '" . $this->getTipoAsiento() .
                "', idayvuelta = '" . $this->getIdaYVuelta() .
                "' WHERE idviaje = " . $id;
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaModificar)) {
                $resultado =  true;
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $resultado;
    }

    //Eliminar Datos
    public function eliminarDatos()
    {
        $baseD = new BaseDatos();
        $resultado = false;
        if ($baseD->conectar()) {
            $consultaBorrar = "DELETE FROM pasajero WHERE idviaje = " . $this->getIdviaje();
            $consultaBorrar = "DELETE FROM viaje WHERE idviaje = " . $this->getIdviaje();
            if ($baseD->ejecutarConsulta($consultaBorrar) && $baseD->ejecutarConsulta($consultaBorrar)) {
                $resultado =  true;
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }

        return $resultado;
    }

    //ToString De Pasajeros
    public function pasajeroToString()
    {
        $coleccionPasajeros = new Pasajero();
        $factor = " idviaje = " . $this->getIdViaje();
        $colPasajeros = $coleccionPasajeros->lista($factor);
        $cadena = "\n";

        foreach ($colPasajeros as $pasajero) {
            $cadena .= $pasajero->__toString() . "\n\t-----------------------------\n";
        }

        return $cadena;
    }

    //ToString
    public function __toString()
    {
        return "\nViaje: " . $this->getIdViaje() .
            "\nDestino: " . $this->getVdestino() .
            "\nCantidad Maxima de Pasajeros: " . $this->getVcantmaxpasajeros() .
            "\nID Empresa: " . $this->getEmpresa() .
            "\nImporte: " . $this->getVimporte() .
            "\nTipo Asiento: " . $this->getTipoAsiento() .
            "\nIda y Vuelta: " . $this->getIdaYVuelta() .
            "\nResponsable: " . $this->getResponsable() .
            "\nPasajeros: " . $this->pasajeroToString();
    }
}
