<?php

class ResponsableV
{
    private $rnumeroEmpleado;
    private $rlicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeDeOperacion;

    //Construct
    public function __construct()
    {
        $this->rnumeroEmpleado = null;
        $this->rlicencia = null;
        $this->rnombre = "";
        $this->rapellido =  "";
    }



    // Getters
    public function getRnumeroEmpleado()
    {
        return $this->rnumeroEmpleado;
    }

    public function getRlicencia()
    {
        return $this->rlicencia;
    }

    public function getRnombre()
    {
        return $this->rnombre;
    }

    public function getRapellido()
    {
        return $this->rapellido;
    }

    public function getMensajeDeOperacion()
    {
        return $this->mensajeDeOperacion;
    }

    // Setters
    public function setRnumeroEmpleado($rnumeroEmpleado)
    {
        $this->rnumeroEmpleado = $rnumeroEmpleado;

        return $this;
    }

    public function setRlicencia($rlicencia)
    {
        $this->rlicencia = $rlicencia;

        return $this;
    }

    public function setRnombre($rnombre)
    {
        $this->rnombre = $rnombre;

        return $this;
    }

    public function setRapellido($rapellido)
    {
        $this->rapellido = $rapellido;

        return $this;
    }

    public function setMensajeDeOperacion($mensajeDeOperacion)
    {
        $this->mensajeDeOperacion = $mensajeDeOperacion;

        return $this;
    }

    //Funciones Magicas
    //Cargar Datos
    public function cargarDatos($rnumeroEmpleado, $rlicencia, $rnombre, $rapellido)
    {
        $this->rnumeroEmpleado = $rnumeroEmpleado;
        $this->rlicencia = $rlicencia;
        $this->rnombre = $rnombre;
        $this->rapellido = $rapellido;
    }

    //Buscar Datos
    public function buscarDatos($rnumeroEmpleado)
    {
        $baseD = new BaseDatos();
        $resultado = false;
        $consultaResponsable = "SELECT * FROM responsable WHERE rnumeroempleado = " . $rnumeroEmpleado;
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaResponsable)) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setRnumeroEmpleado($rnumeroEmpleado);
                    $this->setRnombre($aux['rnombre']);
                    $this->setRapellido($aux['rapellido']);
                    $this->setRlicencia($aux['rnumerolicencia']);
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

    //Coleccion De Responsable
    public function lista($factor = "")
    {
        $baseD = new BaseDatos();
        $coleccionResponsable = null;
        $consultaResponsable = "SELECT * FROM responsable ";
        if ($factor != "") {
            $consultaResponsable = $consultaResponsable . ' where ' . $factor;
        }
        $consultaResponsable .= " order by rnumeroempleado ";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaResponsable)) {
                $coleccionResponsable = array();
                while ($aux = $baseD->registroConsulta()) {
                    $numEmpleado = $aux['rnumeroempleado'];
                    $nombre = $aux['rnombre'];
                    $apellido = $aux['rapellido'];
                    $numLicencia = $aux['rnumerolicencia'];
                    $responsable = new ResponsableV();
                    $responsable->cargarDatos($numEmpleado, $numLicencia, $nombre, $apellido);
                    array_push($coleccionResponsable, $responsable);
                }
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $coleccionResponsable;
    }

    //Insertar Datos
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $resultado = false;
        if ($this->getRnumeroEmpleado() == null) {
            $consultaResponsable = "INSERT INTO responsable(rnumerolicencia, rnombre, rapellido) 
                    VALUES (" . $this->getRlicencia() . ",'" .
                $this->getRnombre() . "','" .
                $this->getRapellido() . "')";
        } else {
            $consultaResponsable = "INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rnombre, rapellido) 
                    VALUES (" . $this->getRnumeroEmpleado() . ",'" .
                $this->getRlicencia() . "','" .
                $this->getRnombre() . "','" .
                $this->getRapellido() . "')";
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaResponsable)) {
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
    public function modificarDatos()
    {
        $baseD = new BaseDatos();
        $resultado = false;
        $consulModificar = "UPDATE responsable 
            SET rnombre = '" . $this->getRnombre() .
            "', rapellido = '" . $this->getRapellido() .
            "', rnumerolicencia = '" . $this->getRlicencia() .
            "' WHERE rnumeroempleado = " . $this->getRnumeroEmpleado();

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
            $consultaBorrar = "DELETE FROM responsable WHERE rnumeroempleado = " . $this->getRnumeroEmpleado();
            if ($baseD->ejecutarConsulta($consultaBorrar)) {
                $resp =  true;
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
        return "\n\tNumero Empleado: " . $this->getRnumeroEmpleado() .
            "\n\tNumero Licencia: " . $this->getRlicencia() .
            "\n\tNombre: " . $this->getRnombre() .
            "\n\tApellido: " . $this->getRapellido() . "\n";
    }
}
