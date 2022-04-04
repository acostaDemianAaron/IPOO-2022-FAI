<?php
/* Enunciado:
La empresa de Transporte de Pasajeros “Viaje Feliz” quiere registrar la información referente 
a sus viajes. De cada viaje se precisa almacenar el código del mismo, destino, cantidad máxima 
de pasajeros y los pasajeros del viaje.
Realice la implementación de la clase Viaje e implemente los métodos necesarios para modificar 
los atributos de dicha clase (incluso los datos de los pasajeros). Utilice un array que almacene 
la información correspondiente a los pasajeros. Cada pasajero es un array asociativo con las 
claves “nombre”, “apellido” y “numero de documento”.
Implementar un script testViaje.php que cree una instancia de la clase Viaje y presente un menú 
que permita cargar la información del viaje, modificar y ver sus datos. */

include "Pasajero.php";
include "Viaje.php";
include "menu.php";

main();