<?php

class pasajero
{

    private $pnombre;
    private $papellido;
    private $rdocumento;
    private $ptelefono;
    private $idviaje;

    //Construct
    public function __construct()
    {
        $this->pnombre = "";
        $this->papellido = "";
        $this->rdocumento = "";
        $this->ptelefono = 0;
        $this->idviaje = null;
    }


    // Getter
    public function getNombre()
    {
        return $this->pnombre;
    }

    public function getApellido()
    {
        return $this->papellido;
    }

    public function getDocumento()
    {
        return $this->rdocumento;
    }

    public function getTelefono()
    {
        return $this->ptelefono;
    }

    public function getIdViaje()
    {
        return $this->idviaje;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    // Setter
    public function setNombre($pnombre)
    {
        $this->pnombre = $pnombre;
    }

    public function setApellido($papellido)
    {
        $this->papellido = $papellido;
    }

    public function setDocumento($rdocumento)
    {
        $this->rdocumento = $rdocumento;
    }

    public function setTelefono($ptelefono)
    {
        $this->ptelefono = $ptelefono;
    }

    public function setIdViaje($id)
    {
        $this->idviaje = $id;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //Funciones Magicas
    public function cargarDatos($nombre, $apellido, $documento, $telefono, $idviaje)
    {
        $this->pnombre = $nombre;
        $this->papellido = $apellido;
        $this->rdocumento = $documento;
        $this->ptelefono = $telefono;
        $this->idviaje = $idviaje;
    }

    //BUSCAR PASAJERO
    //POR DNI
    public function buscarDatos($dni)
    {
        $baseD = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero WHERE rdocumento = " . $dni;
        $resp = false;

        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaPasajero)) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setDocumento($dni);
                    $this->setNombre($aux['pnombre']);
                    $this->setApellido($aux['papellido']);
                    $this->setTelefono($aux['ptelefono']);
                    $this->setIdViaje($aux['idviaje']);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $resp;
    }


    //COLECCION DE PASAJEROS
    public function lista($condic = "")
    {
        $arrPasajeros = null;
        $baseD = new BaseDatos();
        $consultaP = "SELECT * FROM pasajero ";
        if ($condic != "") {
            $consultaP = $consultaP . ' where ' . $condic;
        }
        $consultaP .= " order by rdocumento ";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaP)) {
                $arrPasajeros = array();
                while ($aux = $baseD->registroConsulta()) {

                    $dni = $aux['rdocumento'];
                    $nombre = $aux['pnombre'];
                    $apellido = $aux['papellido'];
                    $telefono = $aux['ptelefono'];
                    $id = $aux['idviaje'];

                    $pasajero = new Pasajero();
                    $pasajero->cargarDatos($nombre, $apellido, $dni, $telefono, $id);
                    array_push($arrPasajeros, $pasajero);
                }
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $arrPasajeros;
    }

    //INSERTAR PASAJERO
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;
        if ($baseD->conectar()) {
            $consulInsetar = "INSERT INTO pasajero(rdocumento, pnombre, papellido, ptelefono, idviaje) 
                    VALUES ('" . $this->getDocumento() . "','" .
                $this->getNombre() . "','" .
                $this->getApellido() . "','" .
                $this->getTelefono() . "','" .
                $this->getIdViaje() . "')";
            if ($baseD->ejecutarConsulta($consulInsetar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $resp;
    }

    //MODIFICAR PASAJERO
    public function modificarDatos($dniViejo = "", $condic = "")
    {
        $resp = false;
        $baseD = new BaseDatos();
        if ($dniViejo == null) {
            $consulModificar = "UPDATE pasajero 
            SET pnombre = '" . $this->getNombre() .
                "', papellido = '" . $this->getApellido() .
                "', ptelefono = '" . $this->getTelefono() .
                "' WHERE rdocumento = " . $this->getDocumento();
        } else {
            $consulModificar = "UPDATE pasajero 
            SET rdocumento = " .  $this->getDocumento() .
                ", pnombre = '" . $this->getNombre() .
                "', papellido = '" . $this->getApellido() .
                "', ptelefono = '" . $this->getTelefono() .
                "' WHERE rdocumento = " . $dniViejo;
        }

        if ($condic != null) {
            $consulModificar = $condic;
        }

        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consulModificar)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $resp;
    }

    //ELIMINAR PASAJERO
    public function eliminarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;
        if ($baseD->conectar()) {
            $consulBorrar = "DELETE FROM pasajero WHERE rdocumento = " . $this->getDocumento();
            if ($baseD->ejecutarConsulta($consulBorrar)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $resp;
    }

    //TOSTRING
    public function __toString()
    {
        return "\n\tNombre: " . $this->getNombre() .
            "\n\tApellido: " . $this->getApellido() .
            "\n\tDNI: " . $this->getDocumento() .
            "\n\tTelefono: " . $this->getTelefono() .
            "\n\tID Viaje que tomara: " . $this->getIdViaje() . "\n";
    }
}
