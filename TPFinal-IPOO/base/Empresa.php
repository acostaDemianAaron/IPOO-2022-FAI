<?php
class Empresa
{
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeOperacion;

    //Construct
    public function __construct()
    {
        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";
    }


    // Getters
    public function getIdempresa()
    {
        return $this->idempresa;
    }

    public function getEnombre()
    {
        return $this->enombre;
    }

    public function getEdireccion()
    {
        return $this->edireccion;
    }


    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    //Setter
    public function setIdempresa($nuevoId)
    {
        $this->idempresa = $nuevoId;
    }

    public function setEnombre($nuevoNom)
    {
        $this->enombre = $nuevoNom;
    }

    public function setEdireccion($nuevaDir)
    {
        $this->edireccion = $nuevaDir;
    }


    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    //Funciones Magicas
    public function cargarDatos($idE, $nomE, $dirE)
    {
        $this->setIdempresa($idE);
        $this->setEnombre($nomE);
        $this->setEdireccion($dirE);
    }

    //BUSCAR DATOS EMPRESA
    //SEGUN IDENTIFICADOR
    public function buscarDatos($id)
    {
        $baseD = new BaseDatos();
        $consultaEmpresa = "SELECT * FROM empresa WHERE idempresa = " . $id;
        $resp = false;

        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaEmpresa)) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setIdempresa($id);
                    $this->setEnombre($aux['enombre']);
                    $this->setEdireccion($aux['edireccion']);
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


    //COLECCION DE EMPRESAS
    public function lista($condic = "")
    {
        $arrEmpresa = null;
        $baseD = new BaseDatos();
        $consultaE = "SELECT * FROM empresa ";
        if ($condic != "") {
            $consultaE = $consultaE . ' where ' . $condic;
        }
        $consultaE .= " order by idempresa ";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaE)) {
                $arrEmpresa = array();
                while ($aux = $baseD->registroConsulta()) {

                    $idempresa = $aux['idempresa'];
                    $enombre = $aux['enombre'];
                    $edireccion = $aux['edireccion'];

                    $empresa = new Empresa();
                    $empresa->cargarDatos($idempresa, $enombre, $edireccion);
                    array_push($arrEmpresa, $empresa);
                }
            } else {
                $this->setMensajeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeOperacion($baseD->getError());
        }
        return $arrEmpresa;
    }

    //INGRESAR DATOS DE EMPRESA
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;
        if ($this->getIdempresa() == null) {
            $queryInsertar = "INSERT INTO empresa(enombre, edireccion) 
                    VALUES ('" . $this->getEnombre() . "','" . $this->getEdireccion() . "')";
        } else {
            $queryInsertar = "INSERT INTO empresa(idempresa, enombre, edireccion) 
                    VALUES (" . $this->getIdempresa() . ",'" . $this->getEnombre() . "','" . $this->getEdireccion() . "')";
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

    //MODIFICAR DATOS DE EMPRESA
    public function modificarDatos($idViejo = "")
    {
        $resp = false;
        $baseD = new BaseDatos();
        if ($idViejo == null) {
            $queryModifica = "UPDATE empresa 
            SET enombre = '" . $this->getEnombre() .
                "', edireccion = '" . $this->getEdireccion() .
                "' WHERE idempresa = " . $this->getIdempresa();
        } else {
            $queryModifica = "UPDATE empresa 
            SET idempresa = " . $this->getIdempresa() .
                ", enombre = '" . $this->getEnombre() .
                "', edireccion = '" . $this->getEdireccion() .
                "' WHERE idempresa = " . $idViejo;
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

    //ELIMINAR DATOS DE EMPRESA
    public function eliminarDatos()
    {
        $baseD = new BaseDatos();
        $resp = false;
        if ($baseD->conectar()) {
            $queryBorrar = "DELETE FROM empresa WHERE idempresa=" . $this->getIdempresa();
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
        return "\nId Empresa: " . $this->getIdempresa() .
            "\nNombre: " . $this->getEnombre() .
            "\nDireccion: " . $this->getEdireccion() . "\n";
    }
}
