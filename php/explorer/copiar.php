<?php


$rutaOrigen = $_POST['origen'];
$rutaDestino = $_POST['destino'];

//Sacamos el nombre del fichero a copiar
$nombre = basename($rutaOrigen);

copy($rutaOrigen,$rutaDestino."/".$nombre);