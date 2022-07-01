<?php
include_once '../base/BaseDatos.php';
include_once '../base/Empresa.php';
include_once '../base/Pasajero.php';
include_once '../base/ResponsableV.php';
include_once '../base/Viaje.php';

//MENU
function menu()
{
    echo "\n" .
        "----------------------------------\n" .
        "               MENU               \n" .
        "----------------------------------\n" .
        "  1. Agregar una empresa          \n" .
        "  2  Agregar un viaje             \n" .
        "  3. Agregar responsable          \n" .
        "  4. Agregar pasajero             \n" .
        "----------------------------------\n" .
        "  5. Modificar una empresa        \n" .
        "  6. Modificar un viaje           \n" .
        "  7. Modificar responsable        \n" .
        "  8. Modificar pasajero           \n" .
        "----------------------------------\n" .
        "  9.  Eliminar una empresa        \n" .
        "  10. Eliminar un viaje           \n" .
        "  11. Eliminar un responsable     \n" .
        "  12. Eliminar un pasajero        \n" .
        "----------------------------------\n" .
        "  13. Ver empresas                \n" .
        "  14. Ver viajes                  \n" .
        "  15. Ver responsables            \n" .
        "  16. Ver pasajeros               \n" .
        "----------------------------------\n" .
        "  0. Salir                        \n" .
        "----------------------------------\n\n";
}
//INGRESAR EMPRESA
function empresaIngresar()
{
    $empresa = new Empresa();

    $id = readline("Id de la empresa: ");
    $nombre = readline("Nombre de la empresa: ");
    $dir = readline("Direccion de la empresa: ");

    if ($id != null) {
        if (!$empresa->buscarDatos($id)) {
            $empresa->cargarDatos($id, $nombre, $dir);

            $respuesta = $empresa->insertarDatos();
            if ($respuesta == true) {
                echo "\n\t   La empresa fue ingresada correctamente a la Base de Datos\n" .
                    "\t--------------------------------------------------------------------\\n";
            } else {
                echo $empresa->getMensajeOperacion();
            }
        } else {
            echo "\nYa existe una empresa con ese ID.\n";
        }
    } else {
        $empresa->setEnombre($nombre);
        $empresa->setEdireccion($dir);

        $respuesta = $empresa->insertarDatos();
        if ($respuesta == true) {
            echo "\n\t   La empresa fue ingresada correctamente a la Base de Datos\n" .
                "\t--------------------------------------------------------------------\\n";
        } else {
            echo $empresa->getMensajeOperacion();
        }
    }
}

//MODIFICAR EMPRESA
function empresaModificar()
{
    $empresa = new Empresa();

    $id = readline("Ingrese el id de la empresa a modificar: ");
    $respuesta = $empresa->buscarDatos($id);

    if ($respuesta) {
        echo "Ingrese los nuevos datos.\n";
        $nuevoid = readline("Id de la empresa: ");
        $nombre = readline("Nombre de la empresa: ");
        $dir = readline("Direccion de la empresa: ");
        if ($nuevoid != "") {
            $empresa->cargarDatos($nuevoid, $nombre, $dir);
        } else {
            $empresa->setEnombre($nombre);
            $empresa->setEdireccion($dir);
        }
        if (!$empresa->buscarDatos($nuevoid)) {
            $respuesta = $empresa->modificarDatos($id);
            if ($respuesta) {
                echo "\n\t   La empresa fue modificada correctamente a la Base de Datos\n" .
                    "\t--------------------------------------------------------------------\n";
            } else {
                echo "\nNo se pudo modificar la empresa en la Base de Datos\n";
            }
        } else {
            echo "\nExiste una empresa con ese id.\n";
        }
    } else {
        echo "No se pudo encontrar la empresa con id = " . $id . "\n";
    }
}

//ELIMINAR EMPRESA
function empresaEliminar()
{
    $empresa = new Empresa();

    $id = readline("Ingrese el id de la empresa a eliminar: ");
    $respuesta = $empresa->buscarDatos($id);

    if ($respuesta) {
        $respuesta = $empresa->eliminarDatos();
        if ($respuesta) {
            echo "\n\t   La empresa fue eliminada correctamente a la Base de Datos\n" .
                "\t--------------------------------------------------------------------\n";
        } else {
            echo "\nNo se pudo eliminar la empresa.\n";
        }
    } else {
        echo "No se pudo encontrar la empresa con id = " . $id . ".\n";
    }
}

//MODIFICAR EMPRESA
function empresaMostrar()
{
    $empresa = new Empresa();

    $resp = readline("Mostrar todas las empresas? (s/n) ");

    if ($resp == 's') {
        $colEmpresas = $empresa->lista("");

        echo "--------------------------------------------------------------------";
        foreach ($colEmpresas as $empresa) {

            echo $empresa;
            echo "--------------------------------------------------------------------";
        }
    } else {
        $id = readline("Ingrese el id de la empresa: ");
        if (is_numeric($id)) {
            $respuesta = $empresa->buscarDatos($id);
            if ($respuesta) {
                echo $empresa;
            } else {
                echo "No se pudo encontrar la empresa.";
            }
        } else {
            echo "ID ingresado no es valido.\n";
        }
    }
}

//INGRESAR VIAJE
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
    $tipoAsiento = readline("Tipo de asiento (Primera clase o no, semicama o cama): ");
    $idayvuelta = readline("Ida y vuelta? ");

    if ($id != null) {
        if (!$viaje->buscarDatos($id)) {
            if (!$viaje->buscarDatos(null, $destino)) {
                if ($empresa->buscarDatos($idempresa) && $responsable->buscarDatos($nempleado)) {
                    $viaje->cargarDatos($id, $destino, $cantmax, $idempresa, $nempleado, $importe, $tipoAsiento, $idayvuelta);

                    $respuesta = $viaje->insertarDatos();
                    if ($respuesta == true) {
                        echo "\n\t   El viaje fue ingresado correctamente a la Base de Datos.\n" .
                            "\t--------------------------------------------------------------------\n";
                    } else {
                        echo $viaje->getMensajeOperacion();
                    }
                } else {
                    echo "\nNo existe la empresa o responsable en la Base de Datos\n";
                }
            } else {
                echo "\nExiste un viaje al destino.\n";
            }
        } else {
            echo "\nYa existe un viaje con ese id.\n";
        }
    } else {
        if ($empresa->buscarDatos($idempresa) && $responsable->buscarDatos($nempleado)) {
            if (!$viaje->buscarDatos(null, $destino)) {
                $viaje->setDestino($destino);
                $viaje->setCantMaxPasajeros($cantmax);
                $viaje->setIdEmpresa($idempresa);
                $viaje->setNumeroEmpleado($nempleado);
                $viaje->setImporte($importe);
                $viaje->setTipoAsiento($tipoAsiento);
                $viaje->setIdaYVuelta($idayvuelta);

                $respuesta = $viaje->insertarDatos();
                if ($respuesta == true) {
                    echo "\n\t   El viaje fue ingresado correctamente a la Base de Datos\n" .
                        "\t--------------------------------------------------------------------\n";
                } else {
                    echo $viaje->getMensajeOperacion();
                }
            } else {
                echo "\nExiste un viaje al destino.\n";
            }
        } else {
            echo "\nNo existe la empresa o responsable a cargo en la Base de Datos\n";
        }
    }
}


//MODIFICAR VIAJE
function viajeModificar()
{
    $viaje = new Viaje();
    $id = readline("Ingrese el id del viaje a modificar: ");

    $respuesta = $viaje->buscarDatos($id);
    if ($respuesta) {
        echo "Ingrese los nuevos datos.\n";
        $nuevoid = readline("Id del viaje: ");
        $destino = readline("Destino del viaje: ");
        $cantmax = readline("Cantidad maxima de pasajeros: ");
        $idempresa = readline("ID de la empresa a cargo: ");
        $nempleado = readline("Numero de empleado responsable: ");
        $importe = readline("Importe: ");
        $tipoAsiento = readline("Elija el tipo de asiento (Primera clase(si o no), semicama o cama): ");
        $idayvuelta = readline("Ida y vuelta? (si/no)");
        if (!$viaje->buscarDatos(null, $destino)) {
            if ($nuevoid != "") {
                $viaje->cargarDatos($nuevoid, $destino, $cantmax, $idempresa, $nempleado, $importe, $tipoAsiento, $idayvuelta);

                $respuesta = $viaje->insertarDatos();
                $pasajeros = new Pasajero();

                $pasajeros->modificarDatos("", "UPDATE pasajero SET idviaje = " . $nuevoid . " WHERE idviaje = " . $id);
                $respuesta = $viaje->buscarDatos($id);
                $respuesta = $viaje->eliminarDatos();
                if ($respuesta) {
                    echo "\n\t   El viaje fue modificado correctamente en la Base de Datos\n" .
                        "\t--------------------------------------------------------------------\n";
                } else {
                    echo "\nNo se pudo crear el nuevo viaje.\n";
                }
            } else {
                $viaje->setDestino($destino);
                $viaje->setCantMaxPasajeros($cantmax);
                $viaje->setIdEmpresa($idempresa);
                $viaje->setNumeroEmpleado($nempleado);
                $viaje->setImporte($importe);
                $viaje->setTipoAsiento($tipoAsiento);
                $viaje->setIdaYVuelta($idayvuelta);
            }
        } else {
            echo "\nExiste un viaje al destino.\n";
        }
    } else {
        echo "No se pudo encontrar el viaje con id = " . $id . ".\n";
    }
}

//ELIMINAR VIAJE
function viajeEliminar()
{
    $viaje = new Viaje();

    $id = readline("Ingrese el id del viaje a eliminar: ");
    $respuesta = $viaje->buscarDatos($id);

    if ($respuesta) {
        $respuesta = $viaje->eliminarDatos();
        if ($respuesta) {
            echo "\n\t   El viaje fue eliminado correctamente a la Base de Datos\n" .
                "\t--------------------------------------------------------------------\n";
        } else {
            echo "\nNo se pudo eliminar el viaje.\n";
        }
    } else {
        echo "No se pudo encontrar el viaje con id = " . $id . ".\n";
    }
}

//MOSTRAR VIAJE
function viajeMostrar()
{
    $viaje = new Viaje();

    $resp = readline("Mostrar todos los viajes? (s/n) ");

    if ($resp == 's') {
        $colViajes = $viaje->lista("");
        foreach ($colViajes as $viaje) {

            echo $viaje;
            echo "\n--------------------------------------------------------------------\n";
        }
    } else {
        $id = readline("Ingrese el id del viaje: ");
        if (is_numeric($id)) {
            $respuesta = $viaje->buscarDatos($id);
            if ($respuesta) {
                echo $viaje;
            } else {
                echo "No se pudo encontrar el viaje.";
            }
        } else {
            echo "ID ingresado no es valido.\n";
        }
    }
}

//INGRESAR RESPONSABLE
function responsableIngresar()
{
    $responsable = new ResponsableV();

    $id = readline("Numero de empleado: ");
    $numLic = readline("Numero de licencia: ");
    $nombre = readline("Nombre del responsable: ");
    $apellido = readline("Apellido del responsable: ");

    if ($id != null) {
        if (!$responsable->buscarDatos($id)) {
            $responsable->cargarDatos($id, $numLic, $nombre, $apellido);

            $respuesta = $responsable->insertarDatos();
            if ($respuesta) {
                echo "\n\t   El responsable fue ingresada correctamente a la Base de Datos\n" .
                    "\t--------------------------------------------------------------------\n";
            } else {
                echo $responsable->getMensajeOperacion();
            }
        } else {
            echo "\nYa existe un responsable con ese ID.\n";
        }
    } else {
        $responsable->setLicencia($numLic);
        $responsable->setNombre($nombre);
        $responsable->setApellido($apellido);

        $respuesta = $responsable->insertarDatos();
        if ($respuesta) {
            echo "\n\t   El responsable fue ingresada correctamente a la Base de Datos.\n" .
                "\t--------------------------------------------------------------------\n";
        } else {
            echo $responsable->getMensajeOperacion();
        }
    }
}

//MODIFICAR RESPONSABLE
function responsableModificar()
{
    $responsable = new ResponsableV();

    $numE = readline("Ingrese el numero de empleado del responsable a modificar: ");
    $respuesta = $responsable->buscarDatos($numE);
    if ($respuesta) {
        echo "Ingrese los nuevos datos.\n";
        $nuevoNumE = readline("Numero de empleado: ");
        $numLic = readline("Numero de licencia: ");
        $nombre = readline("Nombre del responsable: ");
        $apellido = readline("Apellido del responsable: ");
        if ($nuevoNumE != null) {
            $responsable->cargarDatos($nuevoNumE, $numLic, $nombre, $apellido);
        } else {
            $responsable->setLicencia($numLic);
            $responsable->setNombre($nombre);
            $responsable->setApellido($apellido);
        }

        $respuesta = $responsable->modificarDatos($numE);
        if ($respuesta) {
            echo "\n\t   El responsable fue modificada correctamente en la Base de Datos\n" .
                "\t--------------------------------------------------------------------\n";
        } else {
            echo "\nNo se pudo modificar el responsable.\n";
        }
    } else {
        echo "No se pudo encontrar el responsable con numero de empleado: " . $numE . "\n";
    }
}

//ELIMINAR RESPONSABLE
function responsableEliminar()
{
    $responsable = new ResponsableV();

    $numE = readline("Ingrese el numero de empleado del responsable a eliminar: ");
    $respuesta = $responsable->buscarDatos($numE);

    if ($respuesta) {
        $respuesta = $responsable->eliminarDatos();
        if ($respuesta) {
            echo "\n\t   El responsable fue eliminado correctamente de la Base de Datos\n" .
                "\t--------------------------------------------------------------------\n";
        } else {
            echo "\nNo se pudo eliminar el responsable.\n";
        }
    } else {
        echo "No se pudo encontrar el responsable con numero de empleado: " . $numE . ".\n";
    }
}

//MOSTRAR RESPONSABLE
function responsableMostrar()
{
    $responsable = new ResponsableV();

    $resp = readline("Mostrar todos los responsables? (s/n) ");

    if ($resp == 's') {
        $colResponsables = $responsable->lista("");

        echo "-------------------------------------------------------";
        foreach ($colResponsables as $responsable) {

            echo $responsable;
            echo "-------------------------------------------------------";
        }
    } else {
        $numE = readline("Ingrese el numero de empleado: ");
        if (is_numeric($numE)) {
            $respuesta = $responsable->buscarDatos($numE);
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

//INGRESAR PASAJERO
function pasajeroIngresar()
{
    $pasajero = new Pasajero();
    $viaje = new Viaje();

    $dni = readline("Documento de pasajero: ");
    $nombre = readline("Nombre: ");
    $apellido = readline("Apellido: ");
    $telefono = readline("Telefono: ");
    $idviaje = readline("Id del viaje: ");

    if ($viaje->buscarDatos($idviaje)) {
        if (!$pasajero->buscarDatos($dni)) {
            $pasajero->cargarDatos($nombre, $apellido, $dni, $telefono, $idviaje);

            $respuesta = $pasajero->insertarDatos();
            if ($respuesta == true) {
                echo "\n\t   La pasajero fue ingresado correctamente de la Base de Datos.\n" .
                    "\t--------------------------------------------------------------------\n";
            } else {
                echo $pasajero->getMensajeOperacion();
            }
        } else {
            echo "\nYa existe un pasajero con ese documento.\n";
        }
    } else {
        echo "El viaje no existe.\n";
    }
}

//MODIFICAR PASAJERO
function pasajeroModificar()
{
    $pasajero = new Pasajero();
    $viaje = new Viaje();

    $dni = readline("Ingrese el documento del pasajero a modificar: ");
    if (is_numeric($dni)) {
        $respuesta = $pasajero->buscarDatos($dni);
        if ($respuesta) {
            echo "Ingrese los nuevos datos.\n";
            $nuevodni = readline("Documento de pasajero: ");
            $nombre = readline("Nombre: ");
            $apellido = readline("Apellido: ");
            $telefono = readline("Telefono: ");
            $idviaje = readline("Id del viaje: ");

            if ($viaje->buscarDatos($idviaje)) {
                if ($nuevodni != null) {
                    if (!$pasajero->buscarDatos($nuevodni)) {
                        $pasajero->cargarDatos($nombre, $apellido, $nuevodni, $telefono, $idviaje);
                    } else {
                        echo "Ya existe un pasajero con ese documento.\n";
                    }
                } else {
                    $pasajero->setNombre($nombre);
                    $pasajero->setApellido($apellido);
                    $pasajero->setTelefono($telefono);
                    $pasajero->setIdViaje($idviaje);
                }

                $respuesta = $pasajero->modificarDatos($dni);
                if ($respuesta) {
                    echo "\n\t   El pasajero fue modificado correctamente en la Base de Datos\n" .
                        "\t--------------------------------------------------------------------\n";
                } else {
                    echo "\nNo se pudo modificar el pasajero.\n";
                }
            } else {
                echo "El viaje no existe.\n";
                echo "\nNo se pudo modificar el pasajero.\n";
            }
        } else {
            echo "No se pudo encontrar el pasajero de documento: " . $dni . ".\n";
        }
    } else {
        echo "El documento ingresado es incorrecto.\n";
    }
}


//ELIMINAR PASAJERO
function pasajeroEliminar()
{
    $pasajero = new Pasajero();

    $dni = readline("Ingrese el documento del pasajero a eliminar: ");

    if (is_numeric($dni)) {
        $respuesta = $pasajero->buscarDatos($dni);

        if ($respuesta) {
            $respuesta = $pasajero->eliminarDatos();
            if ($respuesta) {
                echo "\n\t   El pasajero fue eliminado correctamente de la Base de Datos\n" .
                    "\t--------------------------------------------------------------------\n";
            } else {
                echo "\nNo se pudo eliminar el pasajero.\n";
            }
        } else {
            echo "No se pudo encontrar el pasajero el documento: " . $dni . ".\n";
        }
    } else {
        echo "El documento ingresado es incorrecto.\n";
    }
}

//MOSTRAR PASAJERO
function pasajeroMostrar()
{
    $pasajero = new Pasajero();

    $resp = readline("Mostrar todos los pasajeros? (s/n) ");

    if ($resp == 's') {
        $colPasajeros = $pasajero->lista("");

        echo "-------------------------------------------------------";
        foreach ($colPasajeros as $pasajero) {

            echo $pasajero;
            echo "-------------------------------------------------------";
        }
    } else {
        $numE = readline("Ingrese documento del pasajero: ");
        if (is_numeric($numE)) {
            $respuesta = $pasajero->buscarDatos($numE);
            if ($respuesta) {
                echo $pasajero;
            } else {
                echo "No se pudo encontrar el pasajero.";
            }
        } else {
            echo "El documetno ingresado no es valido.\n";
        }
    }
}

//MENU DE OPCIONES A ELEJIR
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
            viajeIngresar();
            break;
        case 3:
            responsableIngresar();
            break;
        case 4:
            pasajeroIngresar();
            break;
        case 5:
            empresaModificar();
            break;
        case 6:
            viajeModificar();
            break;
        case 7:
            responsableModificar();
            break;
        case 8:
            pasajeroModificar();
            break;
        case 9:
            empresaEliminar();

            break;
        case 10:
            viajeEliminar();

            break;
        case 11:
            responsableEliminar();
            break;
        case 12:
            pasajeroEliminar();
            break;
        case 13:
            empresaMostrar();

            break;
        case 14:
            viajeMostrar();

            break;
        case 15:
            responsableMostrar();
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
        $res = 's' == readline("Realizar otra operacion? (s/n) ");
    }
    return $res;
}

$res = true;
while ($res) {
    $res = opcionesMenu();
}
echo "--------------------" .
    "\n\tSaliendo...\n" .
    "--------------------";
