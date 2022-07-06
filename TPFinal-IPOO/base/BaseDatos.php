<?php
class BaseDatos
{
    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;



    //Construct
    public function __construct()
    {
        $this->HOSTNAME = "127.0.0.1";
        $this->BASEDATOS = "bdViajes";
        $this->USUARIO = "root";
        $this->CLAVE = "140519"; //Contrasenia
        $this->QUERY = "";
        $this->ERROR = "";
    }

    //Retorna TRUE si se conecto al SERVER y a la BDMysql
    public function conectar()
    {
        $resultado = false;
        $conectar = mysqli_connect($this->HOSTNAME, $this->USUARIO, $this->CLAVE, $this->BASEDATOS);
        if ($conectar) {
            if (mysqli_select_db($conectar, $this->BASEDATOS)) {
                $this->CONEXION = $conectar;
                unset($this->QUERY);
                unset($this->ERROR);
                $resultado = true;
            } else {
                $this->ERROR = mysqli_errno($conectar) . " : " . mysqli_error($conectar);
            }
        }
        return $resultado;
    }


    //EJECUTA Y RECIBE un consulta en una cadena
    public function ejecutarConsulta($consulta)
    {
        $resultado = false;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if ($this->RESULT = mysqli_query($this->CONEXION, $consulta)) {
            $resultado = true;
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . " : " . mysqli_error($this->CONEXION);
        }
        return $resultado;
    }

    //Retorna un registro al a ver realizado una consulta
    public function registroConsulta()
    {
        $resultado = null;
        if ($this->RESULT) {
            unset($this->ERROR);
            if ($aux = mysqli_fetch_assoc($this->RESULT)) {
                $resultado = $aux;
            } else {
                mysqli_free_result($this->RESULT);
            }
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $resultado;
    }


    //Retorna ERROR
    public function getError()
    {
        return "\n" . $this->ERROR;
    }
}
