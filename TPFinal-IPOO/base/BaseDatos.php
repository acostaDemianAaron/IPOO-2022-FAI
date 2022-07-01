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
        $this->CLAVE = "140519"; // Root CLAVE / Contrasenia de usuario Root
        $this->QUERY = "";
        $this->ERROR = "";
    }

  
    //Retorna ERROR cuando tenga mal funcionamiento
    public function getError()
    {
        return "\n" . $this->ERROR;
    }

    //Retorna TRUE si se conecto al SERVER y a la BDMysql
    public function conectar()
    {
        $res = false;
        $conectar = mysqli_connect($this->HOSTNAME, $this->USUARIO, $this->CLAVE, $this->BASEDATOS);
        if ($conectar) {
            if (mysqli_select_db($conectar, $this->BASEDATOS)) {
                $this->CONEXION = $conectar;
                unset($this->QUERY);
                unset($this->ERROR);
                $res = true;
            } else {
                $this->ERROR = mysqli_errno($conectar) . ": " . mysqli_error($conectar);
            }
        }
        return $res;
    }


    //EJECUTA Y RECIBE un consulta en una cadena
    public function ejecutarConsulta($consu)
    {
        $res = false;
        unset($this->ERROR);
        $this->QUERY = $consu;
        if ($this->RESULT = mysqli_query($this->CONEXION, $consu)) {
            $res = true;
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $res;
    }

    //Retorna un registro al a ver realizado una consulta
    public function registroConsulta()
    {
        $res = null;
        if ($this->RESULT) {
            unset($this->ERROR);
            if ($aux = mysqli_fetch_assoc($this->RESULT)) {
                $res = $aux;
            } else {
                mysqli_free_result($this->RESULT);
            }
        } else {
            $this->ERROR = mysqli_errno($this->CONEXION) . ": " . mysqli_error($this->CONEXION);
        }
        return $res;
    }
}
