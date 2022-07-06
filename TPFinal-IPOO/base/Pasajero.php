<?php

class pasajero
{

    private $pnombre;
    private $papellido;
    private $rdocumento;
    private $ptelefono;
    private $idviaje;
    private $mensajeDeOperacion;

    //Construct
    public function __construct()
    {
        $this->pnombre = "";
        $this->papellido = "";
        $this->rdocumento = "";
        $this->ptelefono = 0;
        $this->idviaje;
    }


    //Getters
    public function getPnombre()
    {
        return $this->pnombre;
    }

    public function getPapellido()
    {
        return $this->papellido;
    }

    public function getRdocumento()
    {
        return $this->rdocumento;
    }

    public function getPtelefono()
    {
        return $this->ptelefono;
    }

    public function getIdViaje()
    {
        return $this->idviaje;
    }

    public function getMensajeDeOperacion()
    {
        return $this->mensajeDeOperacion;
    }

    //Setters
    public function setPnombre($pnombre)
    {
        $this->pnombre = $pnombre;

        return $this;
    }

    public function setPapellido($papellido)
    {
        $this->papellido = $papellido;

        return $this;
    }

    public function setRdocumento($rdocumento)
    {
        $this->rdocumento = $rdocumento;

        return $this;
    }

    public function setPtelefono($ptelefono)
    {
        $this->ptelefono = $ptelefono;

        return $this;
    }

    public function setIdviaje($idviaje)
    {
        $this->idviaje = $idviaje;

        return $this;
    }

    public function setMensajeDeOperacion($mensajeDeOperacion)
    {
        $this->mensajeDeOperacion = $mensajeDeOperacion;

        return $this;
    }

    //Funciones Magicas
    //Cargar Datos
    public function cargarDatos($pnombre, $papellido, $rdocumento, $ptelefono, $viaje)
    {
        $this->pnombre = $pnombre;
        $this->papellido = $papellido;
        $this->rdocumento = $rdocumento;
        $this->ptelefono = $ptelefono;
        $this->idviaje = $viaje;
    }

    //Buscar Datos
    public function buscarDatos($dni)
    {
        $baseD = new BaseDatos();
        $viaje = new Viaje();
        $resultado = false;
        $consultaPasajero = "SELECT * FROM pasajero WHERE rdocumento = " . $dni;
        

        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaPasajero)) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setRdocumento($dni);
                    $this->setPnombre($aux['pnombre']);
                    $this->setPapellido($aux['papellido']);
                    $this->setPtelefono($aux['ptelefono']);
                    $this->setIdviaje($viaje->buscarDatos($aux['idviaje'], null));
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


    //Coleccion De Pasajeros
    public function lista($factor)
    {
        $coleccionPasajero = null;
        $baseD = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero WHERE " . $factor . ";";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaPasajero)) {
                $coleccionPasajero = array();
                while ($aux = $baseD->registroConsulta()) {
                    $dni = $aux['rdocumento'];
                    $nombre = $aux['pnombre'];
                    $apellido = $aux['papellido'];
                    $telefono = $aux['ptelefono'];
                    $id = $aux['idviaje'];
                    $pasajero = new Pasajero();
                    $pasajero->cargarDatos($nombre, $apellido, $dni, $telefono, $id);
                    array_push($coleccionPasajero, $pasajero);
                }
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $coleccionPasajero;
    }

    //Insertar Datos
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $resultado = false;
        $viaje = $this->getIdViaje();
        
        if ($baseD->conectar()) {
            $consultaPasajero = "INSERT INTO pasajero(rdocumento, pnombre, papellido, ptelefono, idviaje) 
                    VALUES ('" . $this->getRdocumento() . "','" .
                $this->getPnombre() . "','" .
                $this->getPapellido() . "','" .
                $this->getPtelefono() . "','" .
                $viaje->getIdViaje() . "')";
            if ($baseD->ejecutarConsulta($consultaPasajero)) {
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
    public function modificarDatos($dni = "", $factor = "")
    {
        $baseD = new BaseDatos();
        $resultado = false;
        if ($dni == null) {
            $consulModificar = "UPDATE pasajero 
            SET pnombre = '" . $this->getPnombre() .
                "', papellido = '" . $this->getPapellido() .
                "', ptelefono = '" . $this->getPtelefono() .
                "' WHERE rdocumento = " . $this->getRdocumento();
        } else {
            $consulModificar = "UPDATE pasajero 
            SET rdocumento = " .  $this->getRdocumento() .
                ", pnombre = '" . $this->getPnombre() .
                "', papellido = '" . $this->getPapellido() .
                "', ptelefono = '" . $this->getPtelefono() .
                "' WHERE rdocumento = " . $dni;
        }

        if ($factor != null) {
            $consulModificar = $factor;
        }

        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consulModificar)) {
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
            $consultaBorrar = "DELETE FROM pasajero WHERE rdocumento = " . $this->getRdocumento();
            if ($baseD->ejecutarConsulta($consultaBorrar)) {
                $resultado =  true;
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $resultado;
    }

    //ToString
    public function __toString()
    {
        return "\n\tNombre: " . $this->getPnombre() .
            "\n\tApellido: " . $this->getPapellido() .
            "\n\tDNI: " . $this->getRdocumento() .
            "\n\tTelefono: " . $this->getPtelefono() .
            "\n\tID Viaje:" . $this->getIdviaje() . "\n";
    }

}
