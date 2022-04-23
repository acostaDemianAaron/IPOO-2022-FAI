<?php
/* Modificar la clase Viaje para que ahora los pasajeros sean un objeto que tenga los atributos nombre, apellido, numero de documento y teléfono. 
El viaje ahora contiene una referencia a una colección de objetos de la clase Pasajero. 
También se desea guardar la información de la persona responsable de realizar el viaje, para ello cree una clase ResponsableV que registre el número de empleado,
número de licencia, nombre y apellido. La clase Viaje debe hacer referencia al responsable de realizar el viaje.

Volver a implementar las operaciones que permiten modificar el nombre, apellido y teléfono de un pasajero. 
Luego implementar la operación que agrega los pasajeros al viaje, solicitando por consola la información de los mismos. 
Se debe verificar que el pasajero no este cargado mas de una vez en el viaje. 
De la misma forma cargue la información del responsable del viaje. */
include "Pasajero.php";
include "Viaje.php";
include "ResponsableV.php";

/**
 * Metodo menu que muestra por pantalla las opciones del programa.
 */
function menu()
{
    echo
    "\n+==============================+\n" .
        "|        MENU PRINCIPAL        |\n" .
        "¦==============================¦\n" .
        "| 1. Crear un viaje            |\n" .
        "| 2. Agregar pasajero          |\n" .
        "| 3. Eliminar pasajero         |\n" .
        "| 4. Mostrar datos del viaje   |\n" .
        "| 5. Salir                     |\n" .
        "+==============================+\n\n";
}

/**
 * Metodo para visualizar los datos de un viaje.
 * @param object $viaje
 */
function verDatos($codViaje)
{
    echo $codViaje;
}

/**
 * Metodo para eliminar un pasajero de un viaje especifico.
 * @param object $codViaje
 */
function eliminarPasajero($codViaje)
{
    echo "\n+===============================\n";
    $nombre = readline("Ingrese el DNI del pasajero a eliminar: ");
    $codViaje->eliminarPasajero($nombre);
    echo "+===============================\n\n";
}

/**
 * Metodo para buscar en el almacenamiento si existe un viaje con el codigo ingresado.
 * @param array $destinosAlmacenados
 * @param object $codViaje
 * @return bool
 */
function destinoExiste($destinosAlmacenados, $codViaje)
{
    foreach ($destinosAlmacenados as $destino) {
        if ($destino->getCodigo() == $codViaje) {
            return true;
        }
    }
    return false;
}

/**
 * Metodo main.
 * Muestra el menu y ejecuta las funciones correspondientes.
 */
function main()
{
    // Incializar datos predefinidos.
    $juan = new Pasajero("Juan",    "Perez",     "12345678",    "2994568778");
    $pedro = new Pasajero("Pedro",  "Gomez",     "87654321",    "2995438721");
    $jose = new Pasajero("Jose",    "Gonzalez",  "98765432",    "2996548732");
    $maria = new Pasajero("Maria",  "Lopez",     "54321678",    "2995168778");
    $martin = new Pasajero("Martin","Gomez",     "87675321",    "2995438721");
    $toto = new Pasajero("Toto",    "Gomez",     "87234321",    "2995438721");
    $aaron = new Pasajero("Aaron",  "Acosta",    "41837661",    "2995438721");
    $santi = new Pasajero("Santi",  "Yaitul",    "43130803",    "2995438721");
    $alan = new Pasajero("Alan",    "Vera",      "41591948",    "2995438721");

    $pasajeros = array(
        $juan,
        $pedro,
        $jose,
        $maria,
        $martin,
        $toto,
        $aaron,
        $santi,
        $alan
    );

    $rJuan = new ResponsableV("Juan", "Perez", "1", "2994568778");
    $rAaron = new ResponsableV("Aaron", "Acosta", "666", "2995438721");
    $rSanti = new ResponsableV("Santi", "Yaitul", "69", "2995438721");
    $rAlan = new ResponsableV("Alan", "Vera", "420", "2995438721");

    $Cor = new Viaje("Cordoba", "Cor", "4", $rJuan);
    $Tuc = new Viaje("Tucuman", "Tuc", "6", $rAaron);
    $BsAs = new Viaje("BuenosAires", "BsAs", "3", $rSanti);
    $Ros = new Viaje("Rosario", "Ros", "7", $rAlan);

    $viajes = array();
    array_push($viajes, $Cor);
    array_push($viajes, $Tuc);
    array_push($viajes, $BsAs);
    array_push($viajes, $Ros);

    foreach ($viajes as $viaje) {
        $indice = rand(0, count($pasajeros) - ($viaje->getCantMaxPasajeros() + 1));
        do {
            $viaje->agregarPasajero($pasajeros[$indice]);
            $indice++;
        } while ($viaje->hayCapacidad());
    }
    
    $destinosAlmacenados = $viajes;

    // Menu principal.
    do {
        menu();
        $opcion = readline("Ingrese una opcion: ");
        switch ($opcion) {
            case 1:
                echo "\n+===============================\n";
                $destino = readline("Ingrese el destino: ");
                $codViaje = readline("Ingrese el codigo del viaje: ");
                $cantMaxPasajeros = readline("Ingrese la cantidad maxima de pasajeros: ");
                echo "+===============================\n\n";
                $nombre = readline("Ingrese el nombre del responsable: ");
                $apellido = readline("Ingrese el apellido del responsable: ");
                $numeroEmpleado = readline("Ingrese el numero de empleado: ");
                $numeroLicencia = readline("Ingrese el numero de licencia: ");
                $responsableViaje = new responsableV($nombre, $apellido, $numeroEmpleado, $numeroLicencia);
                $$codViaje = new Viaje($destino, $codViaje, $cantMaxPasajeros, $responsableViaje);
                array_push($destinosAlmacenados, $$codViaje);
                break;
            case 2:
                $codViaje = readline("Ingrese el codigo del viaje: ");
                if (destinoExiste($destinosAlmacenados, $codViaje)) {
                    if ($$codViaje->hayCapacidad()) {
                        echo "\n+===============================\n";
                        $nombre = readline("Ingrese el nombre del pasajero: ");
                        $apellido = readline("Ingrese el apellido del pasajero: ");
                        $dni = readline("Ingrese el dni del pasajero: ");
                        $telefono = readline("Ingrese el telefono del pasajero: ");
                        echo "+===============================\n\n";

                        $$codViaje->agregarPasajero(new Pasajero($nombre, $apellido, $dni, $telefono));
                    } else {
                        echo "Excede el limite de pasajeros.\n";
                    };
                } else {
                    echo "\nNo existe el viaje de codigo " . $codViaje . ".\n";
                }
                break;
            case 3:
                $codViaje = readline("Ingrese el codigo del viaje: ");
                if (destinoExiste($destinosAlmacenados, $codViaje)) {
                    eliminarPasajero($$codViaje);
                } else {
                    echo "\nNo existe el viaje de codigo " . $codViaje . ".\n";
                };
                break;
            case 4:
                $codViaje = readline("Ingrese el codigo del viaje: ");
                if (destinoExiste($destinosAlmacenados, $codViaje)) {
                    verDatos($$codViaje);
                } else {
                    echo "\nNo existe el viaje de codigo " . $codViaje . ".\n";
                };
                break;
            case 5:
                time_nanosleep(0, 300000000);
                echo "\n\t◢ ========================◣\n";
                echo "\t‖     Saliendo...         ‖\n";
                echo "\t◥ ========================◤\n\n";
                time_nanosleep(0, 500000000);
                break;
            default:
                echo "Opcion invalida\n";
        }
    } while ($opcion != 5);

    echo "Destruyendo intancias...\n";
}

main();