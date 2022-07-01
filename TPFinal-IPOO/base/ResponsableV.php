<?php

class ResponsableV
{
    private $rnumeroEmpleado;
    private $rlicencia;
    private $rnombre;
    private $rapellido;

    //Construct
    public function __construct()
    {
        $this->rnumeroEmpleado = null;
        $this->rlicencia = null;
        $this->rnombre = "";
        $this->rapellido =  "";
    }

     
 
     // Getters
     public function getNumeroEmpleado()
     {
         return $this->rnumeroEmpleado;
     }
 
     public function getLicencia()
     {
         return $this->rlicencia;
     }
     public function getNombre()
     {
         return $this->rnombre;
     }
 
     public function getApellido()
     {
         return $this->rapellido;
     }
 
     public function getMensajeOperacion()
     {
         return $this->mensajeOperacion;
     }

     // Setters
     public function setNumeroEmpleado($rnumeroEmpleado)
     {
         return $this->rnumeroEmpleado = $rnumeroEmpleado;
     }
 
     public function setLicencia($rlicencia)
     {
         return $this->rlicencia = $rlicencia;
     }
 
     public function setNombre($rnombre)
     {
         return $this->rnombre = $rnombre;
     }
 
     public function setApellido($rapellido)
     {
         return $this->rapellido = $rapellido;
     }
 
     public function setMensajeOperacion($mensajeOperacion)
     {
         $this->mensajeOperacion = $mensajeOperacion;
     }

    //Funciones Magicas
    public function cargarDatos($numEmpleado, $numlicencia, $nombreResponsable, $apellidoResponsable)
    {
        $this->rnumeroEmpleado = $numEmpleado;
        $this->rlicencia = $numlicencia;
        $this->rnombre = $nombreResponsable;
        $this->rapellido = $apellidoResponsable;
    }

    //BUSCAR RESPONSABLE
    //POR NUMERO DE EMPLEADO
    public function buscarDatos($numEmpleado)
    {
        $baseD = new BaseDatos();
        $consultaR = "SELECT * FROM responsable WHERE rnumeroempleado = " . $numEmpleado;
        $resp = false;

        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaR)) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setNumeroEmpleado($numEmpleado);
                    $this->setNombre($aux['rnombre']);
                    $this->setApellido($aux['rapellido']);
                    $this->setLicencia($aux['rnumerolicencia']);
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

    //COLECCION DE RESPONSABLES
    public function lista($condic = "")
    {
        $arrResponsables = null;
        $baseD = new BaseDatos();
        $consultaP = "SELECT * FROM responsable ";
        if ($condic != "") {
            $consultaP = $consultaP . ' where ' . $condic;
        }
        $consultaP .= " order by rnumeroempleado ";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaP)) {
                $arrResponsables = array();
                while ($row2 = $baseD->registroConsulta()) {

                    $numEmpleado = $row2['rnumeroempleado'];
                    $nombre = $row2['rnombre'];
                    $apellido = $row2['rapellido'];
                    $numLicencia = $row2['rnumerolicencia'];

                    $responsable = new ResponsableV();
                    $responsable->cargarDatos($numEmpleado, $numLicencia, $nombre, $apellido);
                    array_push($arrResponsables, $responsable);
                }
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $arrResponsables;
    }

    //INGRESAR RESPONSABLE
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;
        if ($this->getNumeroEmpleado() == null) {
            $queryInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre, rapellido) 
                    VALUES (" . $this->getLicencia() . ",'" .
                $this->getNombre() . "','" .
                $this->getApellido() . "')";
        } else {
            $queryInsertar = "INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rnombre, rapellido) 
                    VALUES (" . $this->getNumeroEmpleado() . ",'" .
                $this->getLicencia() . "','" .
                $this->getNombre() . "','" .
                $this->getApellido() . "')";
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


    //MODIFICAR RESPONSABLE
    public function modificarDatos($idViejo = "")
    {
        $resp = false;
        $baseD = new BaseDatos();
        if ($idViejo == null) {
            $queryModifica = "UPDATE responsable 
            SET rnombre = '" . $this->getNombre() .
                "', rapellido = '" . $this->getApellido() .
                "', rnumerolicencia = '" . $this->getLicencia() .
                "' WHERE rnumeroempleado = " . $this->getNumeroEmpleado();
        } else {
            $queryModifica = "UPDATE responsable 
            SET rnumeroempleado = " . $this->getNumeroEmpleado() .
                ", rnombre = '" . $this->getNombre() .
                "', rapellido = '" . $this->getApellido() .
                "', rnumerolicencia = '" . $this->getLicencia() .
                "' WHERE rnumeroempleado = " . $idViejo;
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

    //ELIMINAR RESPONSABLE
    public function eliminarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;
        if ($baseD->conectar()) {
            $queryBorrar = "DELETE FROM responsable WHERE rnumeroempleado = " . $this->getNumeroEmpleado();
            if ($baseD->ejecutarConsulta($queryBorrar)) {
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
        return "\n\tNumero Empleado: " . $this->getNumeroEmpleado() .
            "\n\tNumero Licencia: " . $this->getlicencia() .
            "\n\tNombre: " . $this->getNombre() .
            "\n\tApellido: " . $this->getApellido() . "\n";
    }
}
