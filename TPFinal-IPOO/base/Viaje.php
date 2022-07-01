<?php

class viaje
{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa;
    private $rnumeroempleado;
    private $vimporte;
    private $tipoAsiento;
    private $idayvuelta;
    private $pasajeros;
    private $responsable;

    //Construct
    public function __construct()
    {
        $this->idviaje;
        $this->vdestino;
        $this->vcantmaxpasajeros;
        $this->idempresa;
        $this->rnumeroempleado;
        $this->vimporte;
        $this->tipoAsiento;
        $this->idayvuelta;
        $this->pasajeros;
        $this->responsable;
    }

    // Getters 
    public function getIdViaje()
    {
        return $this->idviaje;
    }

    public function getDestino()
    {
        return $this->vdestino;
    }

    public function getCantMaxPasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function getIdEmpresa()
    {
        return $this->idempresa;
    }

    public function getNumeroEmpleado()
    {
        return $this->rnumeroempleado;
    }

    public function getImporte()
    {
        return $this->vimporte;
    }

    public function getTipoAsiento()
    {
        return $this->tipoAsiento;
    }

    public function getIdaYVuelta()
    {
        return $this->idayvuelta;
    }

    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    public function getResponsable()
    {
        return $this->responsable;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    // Setters
    public function setIdViaje($id)
    {
        $this->idviaje = $id;
    }

    public function setDestino($destino)
    {
        $this->vdestino = $destino;
    }

    public function setCantMaxPasajeros($cantidad)
    {
        $this->vcantmaxpasajeros = $cantidad;
    }

    public function setIdEmpresa($id)
    {
        $this->idempresa = $id;
    }

    public function setNumeroEmpleado($numEmpleado)
    {
        $this->rnumeroempleado = $numEmpleado;
    }

    public function setImporte($importe)
    {
        $this->vimporte = $importe;
    }

    public function setTipoAsiento($tipo)
    {
        $this->tipoAsiento = $tipo;
    }

    public function setIdaYVuelta($idayvuelta)
    {
        $this->idayvuelta = $idayvuelta;
    }

    public function setPasajeros($colPasajeros)
    {
        $this->pasajeros = $colPasajeros;
    }

    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //Funciones Magicas
    public function pasajeros()
    {
        $objPasajero = new pasajero();
        $condic = "idviaje = " . $this->getIdViaje();
        $coleccPasajero = $objPasajero->lista($condic);
        $retur = "";
        foreach ($coleccPasajero as $pasajero) {
            $retur .= $pasajero->__toString() . "\n---------";
        }
        return $retur;
    }

    public function cargarDatos($idviaje, $vdestino, $vcantmaxpasajeros, $idempresa, $rnumeroempleado, $vimporte, $tipoAsiento, $idayvuelta)
    {
        $this->idviaje = $idviaje;
        $this->vdestino = $vdestino;
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
        $this->idempresa = $idempresa;
        $this->rnumeroempleado = $rnumeroempleado;
        $this->vimporte = $vimporte;
        $this->tipoAsiento = $tipoAsiento;
        $this->idayvuelta = $idayvuelta;
        $this->buscarEmpleado();
    }

    public function buscarEmpleado()
    {
        $responsable = new ResponsableV();
        $numEmpleado = $this->getNumeroEmpleado();
        $responsable->buscarDatos($numEmpleado);
        $this->setResponsable($responsable);
    }

    //BUSCAR VIAJE
    //POR IDENTIFICADOR
    public function buscarDatos($id = "", $destino = "")
    {
        $baseD = new BaseDatos();
        $resp = false;
        $consultaViaje = "SELECT * FROM viaje WHERE ";
        if ($destino == null) {
            $consultaViaje = $consultaViaje . 'idviaje = ' . $id;
        } else {
            $consultaViaje = $consultaViaje . 'vdestino = "' . $destino . '"';
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaViaje) && $destino == null) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setIdViaje($id);
                    $this->setDestino($aux['vdestino']);
                    $this->setCantMaxPasajeros($aux['vcantmaxpasajeros']);
                    $this->setIdEmpresa($aux['idempresa']);
                    $this->setNumeroEmpleado($aux['rnumeroempleado']);
                    $this->setImporte($aux['vimporte']);
                    $this->setTipoAsiento($aux['tipoAsiento']);
                    $this->setIdaYVuelta($aux['idayvuelta']);
                    $resp = true;
                }
            } else if ($baseD->ejecutarConsulta($consultaViaje)) {
                $resp = ($baseD->registroConsulta() != null);
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $resp;
    }

    //COLECCION DE VIAJES
    public function lista($condic = "")
    {
        $arrViaje = null;
        $baseD = new BaseDatos();
        $consultaV = "SELECT * FROM viaje ";
        if ($condic != "") {
            $consultaV = $consultaV . ' where ' . $condic;
        }
        $consultaV .= " order by idviaje ";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaV)) {
                $arrViaje = array();
                while ($aux = $baseD->registroConsulta()) {

                    $idviaje = $aux['idviaje'];
                    $vdestino = $aux['vdestino'];
                    $vcantmaxpasajeros = $aux['vcantmaxpasajeros'];
                    $idempresa = $aux['idempresa'];
                    $rnumeroempleado = $aux['rnumeroempleado'];
                    $vimporte = $aux['vimporte'];
                    $tipoAsiento = $aux['tipoAsiento'];
                    $idayvuelta = $aux['idayvuelta'];

                    $viaje = new Viaje();
                    $viaje->cargarDatos($idviaje, $vdestino, $vcantmaxpasajeros, $idempresa, $rnumeroempleado, $vimporte, $tipoAsiento, $idayvuelta);
                    array_push($arrViaje, $viaje);
                }
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $arrViaje;
    }

    //INGRESAR VIAJES
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;
        // Por si el usuario especifica o no el id. Se crea uno con AUTO_INCREMENT en caso que no se especifique.
        if ($this->getIdviaje() == null) {
            $queryInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta) 
                    VALUES ('" . $this->getDestino() . "','" .
                $this->getCantMaxPasajeros() .  "','" .
                $this->getIdEmpresa() .  "','" .
                $this->getNumeroEmpleado() .  "','" .
                $this->getImporte() .  "','" .
                $this->getTipoAsiento() .  "','" .
                $this->getIdaYVuelta() .  "')";
        } else {
            $queryInsertar = "INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta)
                    VALUES ('" . $this->getIdViaje() . "','" .
                $this->getDestino() . "','" .
                $this->getCantMaxPasajeros() .  "','" .
                $this->getIdEmpresa() .  "','" .
                $this->getNumeroEmpleado() .  "','" .
                $this->getImporte() .  "','" .
                $this->getTipoAsiento() .  "','" .
                $this->getIdaYVuelta() .  "')";
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($queryInsertar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $resp;
    }

    //MODIFICAR VIAJES
    public function modificarDatos($idViejo = "")
    {
        $resp = false;
        $baseD = new BaseDatos();
        if ($idViejo == null) {
            $queryModifica = "UPDATE viaje 
            SET vdestino = '" . $this->getDestino() .
                "', vcantmaxpasajeros = '" . $this->getCantMaxPasajeros() .
                "', idempresa = '" . $this->getIdEmpresa() .
                "', rnumeroempleado = '" . $this->getNumeroEmpleado() .
                "', vimporte = '" . $this->getImporte() .
                "', tipoAsiento = '" . $this->getTipoAsiento() .
                "', idayvuelta = '" . $this->getIdaYVuelta() .
                "' WHERE idviaje = " . $this->getIdViaje();
        } else {
            $queryModifica = "";
            $queryModifica = "UPDATE viaje 
            SET idviaje = '" . $this->getIdViaje() .
                "', vdestino = '" . $this->getDestino() .
                "', vcantmaxpasajeros = '" . $this->getCantMaxPasajeros() .
                "', idempresa = '" . $this->getIdEmpresa() .
                "', rnumeroempleado = '" . $this->getNumeroEmpleado() .
                "', vimporte = '" . $this->getImporte() .
                "', tipoAsiento = '" . $this->getTipoAsiento() .
                "', idayvuelta = '" . $this->getIdaYVuelta() .
                "' WHERE idviaje = " . $idViejo;
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($queryModifica)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $resp;
    }

    //ELIMINAR VIAJES
    public function eliminarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;

        if ($baseD->conectar()) {
            // Eliminar los pasajeros del viaje primero por la constraint de la key idviaje.
            $queryBorrarP = "DELETE FROM pasajero WHERE idviaje = " . $this->getIdviaje();
            $queryBorrarV = "DELETE FROM viaje WHERE idviaje = " . $this->getIdviaje();
            if ($baseD->ejecutarConsulta($queryBorrarP) && $baseD->ejecutarConsulta($queryBorrarV)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }

        return $resp;
    }

    //TOSTRING DE PASAJEROS
    public function pasajeroToString()
    {
        $objPasajero = new Pasajero();

        $condicion = "idviaje = " . $this->getIdViaje();
        $colPasajeros = $objPasajero->lista($condicion);
        $string = "\n";

        foreach ($colPasajeros as $pasajero) {
            $string .= $pasajero->__toString() . "\n\t-----------------------------\n";
        }
        return $string;
    }

    //TOSTRING
    public function __toString()
    {
        return "\nViaje: " . $this->getIdViaje() .
            "\nDestino: " . $this->getDestino() .
            "\nCantidad Maxima de Pasajeros: " . $this->getCantMaxPasajeros() .
            "\nID Empresa: " . $this->getIdEmpresa() .
            "\nNumero Empleado (Responsable): " . $this->getNumeroEmpleado() .
            "\nImporte: " . $this->getImporte() .
            "\nTipo Asiento: " . $this->getTipoAsiento() .
            "\nIda y Vuelta: " . $this->getIdaYVuelta() .
            "\nResponsable: " . $this->getResponsable() .
            "\nPasajeros: " . $this->pasajeroToString();
    }
}
