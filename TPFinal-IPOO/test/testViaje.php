<?php
include_once '../base/BaseDatos.php';
include_once '../base/Empresa.php';
include_once '../base/Pasajero.php';
include_once '../base/ResponsableV.php';
include_once '../base/Viaje.php';

//Opciones
function menu()
{
    echo "\n" .
        "----------------------------------\n" .
        "               MENU               \n" .
        "----------------------------------\n" .
        "  1. Agregar empresa              \n" .
        "  2. Agregar responsable          \n" .
        "  3. Agregar viaje                \n" .
        "  4. Agregar pasajero             \n" .
        "----------------------------------\n" .
        "  5. Modificar empresa            \n" .
        "  6. Modificar responsable        \n" .
        "  7. Modificar viaje              \n" .
        "  8. Modificar pasajero           \n" .
        "----------------------------------\n" .
        "  9.  Eliminar empresa            \n" .
        "  10. Eliminar responsable        \n" .
        "  11. Eliminar viaje              \n" .
        "  12. Eliminar pasajero           \n" .
        "----------------------------------\n" .
        "  13. Ver empresas                \n" .
        "  14. Ver responsables            \n" .
        "  15. Ver viajes                  \n" .
        "  16. Ver pasajeros               \n" .
        "----------------------------------\n" .
        "  0. Salir                        \n" .
        "----------------------------------\n\n";
}
//Ingresar Empresa
function empresaIngresar()
{
    $empresa = new Empresa();
    $id = readline("Id de la empresa: ");
    $nombre = readline("Nombre de la empresa: ");
    $direccion = readline("Direccion de la empresa: ");
    if ($id == null) {
        $id = 1;
        while ($empresa->buscarDatos($id)) {
            $id++;
        }
    }
    if (!$empresa->buscarDatos($id)) {
        $empresa->cargarDatos($id, $nombre, $direccion);
        $resultado = $empresa->insertarDatos();
        if ($resultado == true) {
            echo "\t--------------------------------------------------------------\n";
            echo "\n\t   La empresa fue ingresada correctamente a la Base de Datos\n" .
                "\t---------------------------------------------------------------\n";
        } else {
            echo $empresa->getMensajeDeOperacion();
        }
    } else {
        echo "\t---------------------------------\n";
        echo "\nYa existe una empresa con ese ID.\n";
        echo "\t---------------------------------\n";
    }
}

//Modificar Empresa
function empresaModificar()
{
    $empresa = new Empresa();
    $id = readline("Ingrese el id de la empresa:");
    $resultado = $empresa->buscarDatos($id);
    if ($resultado) {
        echo "Datos Nuevos\n";
        $nombre = readline("Nombre de la empresa: ");
        $direccion = readline("Direccion de la empresa: ");
        $empresa->setEnombre($nombre);
        $empresa->setEdireccion($direccion);
        $resultado = $empresa->modificarDatos();
        if ($resultado) {
            echo "\t---------------------------------------------------------------\n";
            echo "\n\t   La empresa fue modificada correctamente a la Base de Datos\n" .
                "\t----------------------------------------------------------------\n";
        } else {
            echo "\nNo se pudo modificar la empresa.\n";
        }
    } else {
        echo "No se pudo encontrar la empresa con id = " . $id . "\n";
    }
}

//Eliminar Empresa
function empresaEliminar()
{
    $empresa = new Empresa();
    $viaje = new Viaje();
    $id = readline("Ingrese el id de la empresa a eliminar: ");
    $resultado = $empresa->buscarDatos($id);
    if ($resultado) {
        if ($viaje->buscarDatos(null, "idempresa = " . $id)) {
            $eliminarEmpresa = readline("Esta empresa tiene un viaje. Quiere eliminar el viaje? (si/no) ");
            if ($eliminarEmpresa == "si") {
                $viaje->eliminarDatos();
                $empresaE = false;
            } else {
                $empresaE = true;
            }
        } else {
            $empresaE = false;
        }
        if (!$empresaE) {
            $resultado = $empresa->eliminarDatos();
            if ($resultado) {
                echo "\t--------------------------------------------------------------\n";
                echo "\n\t   La empresa fue eliminada correctamente a la Base de Datos\n" .
                    "\t---------------------------------------------------------------\n";
            } else {
                echo "\nNo se pudo eliminar la empresa.\n";
            }
        } else {
            echo "\nNo se puede eliminar esta empresa tiene datos a cargo\n";
        }
    } else {
        echo "No se pudo encontrar la empresa con id = " . $id . ".\n";
    }
}

//Mostrar Empresa
function empresaMostrar()
{
    $empresa = new Empresa();
    $resultado = readline("Mostrar todas las empresas? (si/no) ");

    if ($resultado == 'si') {
        $coleccionEmpresa = $empresa->lista("");
        echo "---------------------------------";
        foreach ($coleccionEmpresa as $empresa) {
            echo $empresa;
            echo "---------------------------------";
        }
    } else {
        $id = readline("Ingrese el id de la empresa: ");
        if (is_numeric($id)) {
            $respuesta = $empresa->buscarDatos($id);
            if ($respuesta) {
                echo $empresa;
            } else {
                echo "No se a encontrar la empresa.";
            }
        } else {
            echo "El id ingresado no existe.\n";
        }
    }
}





//Ingresar Viaje
function viajeIngresar()
{
    $viaje = new Viaje();
    $empresa = new Empresa();
    $responsable = new ResponsableV();
    $id = readline("Id del viaje: ");
    $destino = readline("Destino del viaje: ");
    $cantmax = readline("Cantidad maxima de pasajeros: ");
    $idempresa = readline("ID de la empresa a cargo: ");
    $nempleado = readline("Numero de empleado responsable: ");
    $importe = readline("Importe: ");
    $tipoAsiento = readline("Tipo de asiento (primera clase, semicama o cama): ");
    $idayvuelta = readline("Ida y vuelta? ");
    if ($id == null) {
        $id = 1;
        while ($viaje->buscarDatos($id, null)) {
            $id++;
        }
    }
    if (!$viaje->buscarDatos($id, "")) {
        if (!$viaje->buscarDatos(null,  "vdestino = '" . $destino . "'")) {
            if ($empresa->buscarDatos($idempresa) && $responsable->buscarDatos($nempleado)) {
                $viaje->cargarDatos($id, $destino, $cantmax, $empresa, $responsable, $importe, $tipoAsiento, $idayvuelta);
                $respuesta = $viaje->insertarDatos();
                if ($respuesta == true) {
                    echo "\t------------------------------------------------------------\n";
                    echo "\n\t   El viaje fue ingresado correctamente a la Base de Datos\n" .
                        "\t-------------------------------------------------------------\n";
                } else {
                    echo $viaje->getMensajeDeOperacion();
                }
            } else {
                echo "\nNo existe la empresa a cargo.\n";
            }
        } else {
            echo "\nExiste un viaje al destino.\n";
        }
    } else {
        echo "\nYa existe un viaje con ese id.\n";
    }
}

//Modificar Viaje
function viajeModificar()
{
    $viaje = new Viaje();
    $empresa = new Empresa();
    $responsable = new ResponsableV();
    $id = readline("Ingrese el id del viaje a modificar: ");

    $resultado = $viaje->buscarDatos($id, null);
    if ($resultado) {
        echo "Ingrese los nuevos datos.\n";
        $destino = readline("Destino del viaje: ");
        $cantmax = readline("Cantidad maxima de pasajeros: ");
        $idempresa = readline("ID de la empresa a cargo: ");
        $nempleado = readline("Numero de empleado responsable: ");
        $importe = readline("Importe: ");
        $tipoAsiento = readline("primera clase o no, semicama o cama):");
        $idayvuelta = readline("Ida y vuelta? ");
        if (!$viaje->buscarDatos(null, "vdestino = '" . $destino . "'")) {
            if ($empresa->buscarDatos($idempresa) && $responsable->buscarDatos($nempleado)) {
                $viaje->setVdestino($destino);
                $viaje->setVcantmaxpasajeros($cantmax);
                $viaje->setEmpresa($empresa);
                $viaje->setResponsable($responsable);
                $viaje->setVimporte($importe);
                $viaje->setTipoAsiento($tipoAsiento);
                $viaje->setIdaYVuelta($idayvuelta);
                $resultado = $viaje->modificarDatos();
                if ($resultado) {
                    echo "\t------------------------------------------------------------\n";
                    echo "\n\t   El viaje fue modificado correctamente a la Base de Datos\n" .
                        "\t-------------------------------------------------------------\n";
                } else {
                    echo "\nNo se pudo modificar el viaje\n";
                }
            } else {
                echo "\nLos datos del responsable o la empresa estan mal.\n";
            }
        } else {
            echo "\nExiste un viaje al destino.\n";
        }
    } else {
        echo "No se pudo encontrar el viaje con id = " . $id . ".\n";
    }
}

//Eliminar Viaje
function viajeEliminar(){
    $viaje = new Viaje();
    $pasajero = new Pasajero();
    $pasajeroE = false;

    $id = readline("Ingrese el id del viaje a eliminar: ");
    $resultado = $viaje->buscarDatos($id, null);
    if ($resultado) {
        if ($pasajero->buscarDatos(null, "idviaje = " . $id)) {
            $eliminarViaje = readline("El viaje tiene pasajeros. Quiere eliminar el viaje? (si/no) ");
            if ($eliminarViaje == "si") {
                $pasajeroE = false;
            } else {
                $pasajeroE = true;
            }
        }

        if (!$pasajeroE) {
            $resultado = $viaje->eliminarDatos();
            if ($resultado) {
                echo "\t------------------------------------------------------------\n";
                echo "\n\t   El viaje fue eliminado correctamente a la Base de Datos\n" .
                    "\t-------------------------------------------------------------\n";
            } else {
                echo "\nNo se pudo eliminar el viaje.\n";
            }
        } else {
            echo "\nNo se puede eliminar el viaje. Sin borrar a los pasajeros antes\n";
        }
    } else {
        echo "No se pudo encontrar el viaje con id = " . $id . ".\n";
    }
}

//Mostrar Viaje
function viajeMostrar()
{
    $viaje = new Viaje();
    $resultado = readline("Mostrar todos los viajes? (si/no) ");
    if ($resultado == 'si') {
        $coleccionViaje = $viaje->lista("");
        foreach ($coleccionViaje as $viaje) {
            echo $viaje;
            echo "\n---------------------------------\n";
        }
    } else {
        $id = readline("Ingrese el id del viaje: ");
        if (is_numeric($id)) {
            $respuesta = $viaje->buscarDatos($id, null);
            if ($respuesta) {
                echo $viaje;
            } else {
                echo "El viaje no exite.";
            }
        } else {
            echo "El id no existe\n";
        }
    }
}




//Ingresar Responsable
function responsableIngresar()
{
    $responsable = new ResponsableV();
    $id = readline("Numero de empleado: ");
    $rlicencia = readline("Numero de licencia: ");
    $nombre = readline("Nombre del responsable: ");
    $apellido = readline("Apellido del responsable: ");
    if ($id == null) {
        $id = 1;
        while ($responsable->buscarDatos($id)) {
            $id++;
        }
    }
    if (!$responsable->buscarDatos($id)) {
        $responsable->cargarDatos($id, $rlicencia, $nombre, $apellido);
        $resultado = $responsable->insertarDatos();
        if ($resultado) {
            echo "\t------------------------------------------------------------------\n";
            echo "\n\t   El responsable fue ingresada correctamente a la Base de Datos\n" .
                "\t-------------------------------------------------------------------\n";
        } else {
            echo $responsable->getMensajeDeOperacion();
        }
    } else {
        echo "\nYa existe un responsable con ese id.\n";
    }
}

//Modificar Responsable
function responsableModificar()
{
    $responsable = new ResponsableV();
    $rnumeroEmpleado = readline("Ingrese el numero de empleado del responsable: ");
    $resultado = $responsable->buscarDatos($rnumeroEmpleado);
    if ($resultado) {
        echo "Datos Nuevos\n";
        $rlicencia = readline("Numero de licencia: ");
        $nombre = readline("Nombre del responsable: ");
        $apellido = readline("Apellido del responsable: ");
        $responsable->setRlicencia($rlicencia);
        $responsable->setRnombre($nombre);
        $responsable->setRapellido($apellido);
        $resultado = $responsable->modificarDatos($rnumeroEmpleado);
        if ($resultado) {
            echo "\t--------------------------------------------------------------------\n";
            echo "\n\t   El responsable fue modificada correctamente a la Base de Datos.\n" .
                "\t---------------------------------------------------------------------\n";
        } else {
            echo "\nNo se pudo modificar.\n";
        }
    } else {
        echo "No se pudo encontrar el responsable con numero de empleado: " . $rnumeroEmpleado . "\n";
    }
}

//Eliminar Responsable
function responsableEliminar()
{
    $responsable = new ResponsableV();
    $viaje = new Viaje();
    $eliminarViaje = "no";
    $rnumeroEmpleado = readline("Ingrese el numero del responsable a eliminar: ");
    $resultado = $responsable->buscarDatos($rnumeroEmpleado);

    if ($resultado) {
        if ($viaje->buscarDatos(null, "rnumeroempleado = " . $rnumeroEmpleado)) {
            $eliminarViaje = readline("Tiene un viaje. Quiere eliminar el viaje junto al responsable? (si/no) ");
            if ($eliminarViaje == "si") {
                $viaje->eliminarDatos();
                $viajeE = false;
            } else {
                $viajeE = true;
            }
        } else {
            $viajeE = false;
        }

        if (!$viajeE) {
            $resultado = $responsable->eliminarDatos();
            if ($resultado) {
                echo "\t-------------------------------------------------------------------\n";
                echo "\n\t   El responsable fue eliminado correctamente a la Base de Datos.\n" .
                    "\t------------------------------------------------------------------------\n";
            } else {
                echo "\nNo se pudo eliminar el responsable.\n";
            }
        } else {
            echo "\nNo se puede eliminar un responsable tiene un viaje a cargo.\n";
        }
    } else {
        echo "No se pudo encontrar el responsable con numero de empleado: " . $rnumeroEmpleado . ".\n";
    }
}

//Mostrar Responsable
function responsableMostrar()
{
    $responsable = new ResponsableV();
    $resultado = readline("Mostrar todos los responsables? (si/no) ");
    if ($resultado == 'si') {
        $coleccionResponsable = $responsable->lista("");
        echo "---------------------------------";
        foreach ($coleccionResponsable as $responsable) {
            echo $responsable;
            echo "---------------------------------";
        }
    } else {
        $rnumeroEmpleado = readline("Ingrese el numero de empleado: ");
        if (is_numeric($rnumeroEmpleado)) {
            $respuesta = $responsable->buscarDatos($rnumeroEmpleado);
            if ($respuesta) {
                echo $responsable;
            } else {
                echo "No se pudo encontrar el responsable.";
            }
        } else {
            echo "El valor ingresado no es valido.\n";
        }
    }
}




//Ingresar Pasajero
function pasajeroIngresar()
{
    $pasajero = new Pasajero();
    $viaje = new Viaje();
    $dni = readline("DNI de pasajero: ");
    $nombre = readline("Nombre: ");
    $apellido = readline("Apellido: ");
    $telefono = readline("Telefono: ");
    $idviaje = readline("Id del viaje: ");
    if ($viaje->buscarDatos($idviaje, null)) {
        if (!$pasajero->buscarDatos($dni, null)) {
            $pasajero->cargarDatos($nombre, $apellido, $dni, $telefono, $viaje);
            $resultado = $pasajero->insertarDatos();
            if ($resultado == true) {
                echo "\t----------------------------------------------------------------\n";
                echo "\n\t   La pasajero fue ingresado correctamente a la Base de Datos.\n" .
                    "\t-----------------------------------------------------------------\n";
            } else {
                echo $pasajero->getMensajeDeOperacion();
            }
        } else {
            echo "\nYa existe un pasajero con ese DNI.\n";
        }
    } else {
        echo "El viaje no existe.\n";
    }
}

//Modificar Pasajero
function pasajeroModificar()
{
    $pasajero = new Pasajero();
    $viaje = new Viaje();
    $dni = readline("Ingrese el DNI del pasajero: ");
    if (is_numeric($dni)) {
        $resultado = $pasajero->buscarDatos($dni, null);
        if ($resultado) {
            echo "Datos Nuevos\n";
            $nuevodni = readline("DNI de pasajero: ");
            $nombre = readline("Nombre: ");
            $apellido = readline("Apellido: ");
            $telefono = readline("Telefono: ");
            $idviaje = readline("Id del viaje: ");
            if ($viaje->buscarDatos($idviaje, null)) {
                    $pasajero->setPnombre($nombre);
                    $pasajero->setPapellido($apellido);
                    $pasajero->setPtelefono($telefono);
                    $pasajero->setIdviaje($viaje);
                $resultado = $pasajero->modificarDatos(null);
                if ($resultado) {
                    echo "\t----------------------------------------------------------------\n";
                    echo "\n\t   El pasajero fue modificado correctamente a la Base de Datos.\n" .
                        "\t-----------------------------------------------------------------\n";
                } else {
                    echo "\nNo se pudo modificar.\n";
                }
            } else {
                echo "\nNo se pudo modificar. Porque el viaje no existe.\n";
            }
        } else {
            echo "No se pudo encontrar el pasajero de documento: " . $dni . ".\n";
        }
    } else {
        echo "El DNI ingresado no existe.\n";
    }
}

//Eliminar Pasajero
function pasajeroEliminar()
{
    $pasajero = new Pasajero();
    $dni = readline("Ingrese el documento del pasajero: ");
    if (is_numeric($dni)) {
        $resultado = $pasajero->buscarDatos($dni, null);
        if ($resultado) {
            $resultado = $pasajero->eliminarDatos();
            if ($resultado) {
                echo "\t----------------------------------------------------------------\n";
                echo "\n\t   El pasajero fue eliminado correctamente a la Base de Datos..\n" .
                "\t-----------------------------------------------------------------\n";
            } else {
                echo "\nNo se pudo eliminar.\n";
            }
        } else {
            echo "No se pudo encontrar el pasajero el DNI: " . $dni . ".\n";
        }
    } else {
        echo "El DNI ingresado no existe.\n";
    }
}

//Mostrar Pasajero
function pasajeroMostrar()
{
    $pasajero = new Pasajero();
    $resultado = readline("Mostrar todos los pasajeros? (si/no) ");
    if ($resultado == 'si') {
        $coleccionPasajeros = $pasajero->lista("");
        echo "---------------------------------";
        foreach ($coleccionPasajeros as $pasajero) {
            echo $pasajero;
            echo "---------------------------------";
        }
    } else {
        $doc = readline("Ingrese DNI del pasajero: ");
        if (is_numeric($doc)) {
            $respuesta = $pasajero->buscarDatos($doc, null);
            if ($respuesta) {
                echo $pasajero;
            } else {
                echo "El pasajero no existe.";
            }
        } else {
            echo "El DNI ingresado no existe.\n";
        }
    }
}





//Menu
function opcionesMenu()
{
    menu();
    $res = false;
    $opcion = readline("Elija una opcion: ");
    switch ($opcion) {
        case 0:
            $res = false;
            break;
        case 1:
            empresaIngresar();
            break;
        case 2:
            responsableIngresar();
            break;
        case 3:
            viajeIngresar();
            break;
        case 4:
            pasajeroIngresar();
            break;
        case 5:
            empresaModificar();
            break;
        case 6:
            responsableModificar();
            break;
        case 7:
            viajeModificar();
            break;
        case 8:
            pasajeroModificar();
            break;
        case 9:
            empresaEliminar();
            break;
        case 10:
            responsableEliminar();
            break;
        case 11:
            viajeEliminar();
            break;
        case 12:
            pasajeroEliminar();
            break;
        case 13:
            empresaMostrar();
            break;
        case 14:
            responsableMostrar();
            break;
        case 15:
            viajeMostrar();
            break;
        case 16:
            pasajeroMostrar();
            break;
        default:
            echo "Opcion invalida. Tienes que ingresar un valor de 1 al 16";
            time_nanosleep(2, 0);
            $res = true;
    }
    echo "\n";
    if ($opcion != 0 && ($opcion > 0 && $opcion <= 16)) {
        $res = 'si' == readline("Realizar otra operacion? (si/no) ");
    }
    return $res;
}

$res = true;
while ($res) {
    $res = opcionesMenu();
}

echo "Vacaciones. xD";