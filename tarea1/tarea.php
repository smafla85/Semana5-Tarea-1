<?php

// 1. Integer
$edad = 39; 

// 2. Float
$peso = 77.5; 

// 3. String
$nombre = "Leonardo Mafla."; 

// 4. Boolean
$esDeportista = false; 

// 5. Array
$vehiculos = array("bicicleta", "moto", "avion", "barco", "tren");

// Operaciones aritméticas
$suma = $edad + $peso;
$cociente = $edad / $peso;

// Muestra Resultados
echo "La suma de la edad y el peso es: $suma <br>";
echo "El cociente de la edad y el peso es: $cociente <br>";

// Crea una variable de tipo cadena
$cadena1 = "Hola soy, ";

// Concatenación de dos cadenas
$cadenaConcatenada = $cadena1 . $nombre; 

// Obtener la longitud de la cadena
$longitudCadena = strlen($cadenaConcatenada); 

// Mostrar los resultados
echo "Cadena concatenada: $cadenaConcatenada <br>";
echo "Longitud de la cadena concatenada: $longitudCadena caracteres <br>";

// Estructura de control condicional
if ($esDeportista) {
    echo "El usuario es un deportista. <br>";
} else {
    echo "El usuario no es un deportista. <br>";
}

// Mostrar un elemento específico del arreglo utilizando su índice
$vehiculo = 0;
$vehiculoEspecifico = $vehiculos[$vehiculo];
echo "El vehículo en el índice $vehiculo es: $vehiculoEspecifico <br>";

?>
