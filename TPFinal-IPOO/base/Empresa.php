<?php
class Empresa
{
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeDeOperacion;

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

    public function getMensajeDeOperacion()
    {
        return $this->mensajeDeOperacion;
    }

    //Setter
    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;

        return $this;
    }

    public function setEnombre($enombre)
    {
        $this->enombre = $enombre;

        return $this;
    }

    public function setEdireccion($edireccion)
    {
        $this->edireccion = $edireccion;

        return $this;
    }

    public function setMensajeDeOperacion($mensajeDeOperacion)
    {
        $this->mensajeDeOperacion = $mensajeDeOperacion;

        return $this;
    }

    //Funciones Magicas
    //Cargar Datos
    public function cargarDatos($idempresa, $enombre, $edireccion)
    {
        $this->setIdempresa($idempresa);
        $this->setEnombre($enombre);
        $this->setEdireccion($edireccion);
    }

    //Buscar Datos
    public function buscarDatos($idempresa)
    {
        $baseD = new BaseDatos();
        $resultado = false;
        $consultaIdEmpresa = "SELECT * FROM empresa WHERE idempresa = " . $idempresa;
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaIdEmpresa)) {
                if ($aux = $baseD->registroConsulta()) {
                    $this->setIdempresa($idempresa);
                    $this->setEnombre($aux['enombre']);
                    $this->setEdireccion($aux['edireccion']);
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


    //Coleccion De Empresas
    public function lista($factor = "")
    {
        $baseD = new BaseDatos();
        $coleccionEmpresa = null;
        $consultaEmpresa = "SELECT * FROM empresa ";
        if ($factor != "") {
            $consultaEmpresa = $consultaEmpresa . ' where ' . $factor;
        }
        $consultaEmpresa .= " order by idempresa ";
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaEmpresa)) {
                $coleccionEmpresa = array();
                while ($aux = $baseD->registroConsulta()) {
                    $idempresa = $aux['idempresa'];
                    $enombre = $aux['enombre'];
                    $edireccion = $aux['edireccion'];
                    $empresa = new Empresa();
                    $empresa->cargarDatos($idempresa, $enombre, $edireccion);
                    array_push($coleccionEmpresa, $empresa);
                }
            } else {
                $this->setMensajeDeOperacion($baseD->getError());
            }
        } else {
            $this->setMensajeDeOperacion($baseD->getError());
        }
        return $coleccionEmpresa;
    }

    //Insertar Datos
    public function insertarDatos()
    {
        $baseD = new BaseDatos();
        $resultado = false;
        if ($this->getIdempresa() == null) {
            $consultaEmpresa = "INSERT INTO empresa(enombre, edireccion) 
                    VALUES ('" . $this->getEnombre() . "','" . $this->getEdireccion() . "')";
        } else {
            $consultaEmpresa = "INSERT INTO empresa(idempresa, enombre, edireccion) 
                    VALUES (" . $this->getIdempresa() . ",'" . $this->getEnombre() . "','" . $this->getEdireccion() . "')";
        }
        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaEmpresa)) {
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
        $consultaModifica = "UPDATE empresa 
            SET enombre = '" . $this->getEnombre() .
            "', edireccion = '" . $this->getEdireccion() .
            "' WHERE idempresa = " . $this->getIdempresa();

        if ($baseD->conectar()) {
            if ($baseD->ejecutarConsulta($consultaModifica)) {
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
            $consultaBorrar = "DELETE FROM empresa WHERE idempresa=" . $this->getIdempresa();
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
        return "\nEmpresa: " . $this->getIdempresa() .
            "\nNombre: " . $this->getEnombre() .
            "\nDireccion: " . $this->getEdireccion() . "\n";
    }
}
