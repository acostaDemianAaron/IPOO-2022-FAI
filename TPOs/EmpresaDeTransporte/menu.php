<?php
function menu()
{
    echo
    "\n◢==============================◣\n" .
        "|        MENU PRINCIPAL        |\n" .
        "¦==============================¦\n" .
        "| 1. Crear un viaje            |\n" .
        "| 2. Agregar pasajero          |\n" .
        "| 3. Eliminar pasajero         |\n" .
        "| 4. Mostrar datos del viaje   |\n" .
        "| 5. Salir                     |\n" .
        "◥==============================◤\n\n";
}

function verDatos($objViaje)
{
    echo $objViaje;
}

function agPasajero($objViaje)
{

    $nombre = readline("Ingrese el nombre del pasajero: ");
    $apellido = readline("Ingrese el apellido del pasajero: ");
    $dni = readline("Ingrese el dni del pasajero: ");

    $objViaje->agregarPasajero(new Pasajero($nombre, $apellido, $dni));
}

function eliminarPasajero($objViaje)
{
    $nombre = readline("Ingrese el DNI del pasajero a eliminar: ");
    $objViaje->eliminarPasajero($nombre);
}

function destinoExiste($destinos, $codigo)
{
    foreach ($destinos as $destino) {
        if ($destino->getCodigo() == $codigo) {
            return true;
        }
    }
    return false;
}

function main()
{
    $destinos = [];
    do {
        menu();
        $opcion = readline("Ingrese una opcion: ");
        switch ($opcion) {
            case 1:
                $destino = readline("Ingrese el destino: ");
                $codigo = readline("Ingrese el codigo: ");
                $cantMaxPasajeros = readline("Ingrese la cantidad maxima de pasajeros: ");
                $$codigo = new Viaje($destino, $codigo, $cantMaxPasajeros);
                array_push($destinos, $$codigo);
                echo "Viaje con destino a " . $destino . " creado.\n";
                break;
            case 2:
                $codigo = readline("Ingrese el codigo del viaje: ");
                if (destinoExiste($destinos, $codigo)) {
                    if ($$codigo->hayCapacidad()) {
                        agPasajero($$codigo);
                    } else {
                        time_nanosleep(0, 300000000);
                        echo "\n\t◢ ============================◣\n";
                        echo "\t‖Excede el limite de pasajeros‖\n";
                        echo "\t◥ ============================◤\n\n";
                        time_nanosleep(0, 500000000);
                    }
                } else {
                    time_nanosleep(0, 300000000);
                    echo "\n\t◢ ================◣\n";
                    echo "\t‖No existe el viaje‖\n";
                    echo "\t◥ ==================◤\n\n";
                    time_nanosleep(0, 500000000);
                }
                break;
            case 3:
                $codigo = readline("Ingrese el codigo del viaje: ");
                if (destinoExiste($destinos, $codigo)) {
                    eliminarPasajero($$codigo);
                } else {
                    time_nanosleep(0, 300000000);
                    echo "\n\t◢ =================◣\n";
                    echo "\t‖No existe el viaje‖\n";
                    echo "\t◥ =================◤\n\n";
                    time_nanosleep(0, 500000000);
                }

                break;
            case 4:
                $codigo = readline("Ingrese el codigo del viaje: ");
                if (destinoExiste($destinos, $codigo)) {
                    verDatos($$codigo);
                } else {
                    time_nanosleep(0, 300000000);
                    echo "\n\t◢ =========================◣\n";
                    echo "\t‖No existen datos de viajes‖\n";
                    echo "\t◥ =========================◤\n\n";
                    time_nanosleep(0, 500000000);
                }
                break;
            case 5:
                time_nanosleep(0, 300000000);
                echo "\n\t◢ ========================◣\n";
                echo "\t‖     Saliendo...         ‖\n";
                echo "\t◥ ========================◤\n\n";
                time_nanosleep(0, 500000000);
                break;
            default:
                time_nanosleep(0, 300000000);
                echo "\n\t◢ ========================◣\n";
                echo "\t‖     Opcion invalida     ‖\n";
                echo "\t◥ ========================◤\n\n";
                echo " ";
                time_nanosleep(0, 500000000);
        }
    } while ($opcion != 5);

    echo "Destruyendo intancias...\n";
}
