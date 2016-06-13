<?php

session_start();
include('../../php/bbdd/ftp-bbdd.php');

$nombre = $_POST['nombre'];

/**/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SESSION['ultimaAccion']['localoftp'] == "local") {
    $path = $_SESSION['localurl'] . "/" . $nombre;

    if (!is_dir($path)) {
        mkdir($path);
        echo "La carpeta se ha creado satisfactoriamente";
    } else {
        echo "Ya existe una carpeta con el mismo nombre ";
    }
}else {

    /*Cogemos la ruta actual para saber en que ftp y ruta crear la carpeta*/
    $idftp = $_SESSION['ultimaAccion']['idftp'];

    $ftp = FTP::verFTP($idftp);
    $url = $_SESSION['ultimaAccion']['url'];
    
    define("SERVER", $ftp['url']); //IP o Nombre del Servidor
    define("PORT", $ftp['port']); //Puerto
    define("USER", $ftp['nick']); //Nombre de Usuario
    define("PASSWORD", $ftp['pass']); //Contraseña de acceso
    define("PASV", true); //Activa modo pasivo

    
    $id_ftp = ftp_connect(SERVER, PORT); //Obtiene un manejador del Servidor FTP
    ftp_login($id_ftp, USER, PASSWORD); //Se loguea al Servidor FTP
    ftp_pasv($id_ftp, PASV); //Establece el modo de conexión
 
    /*Preparamos la ruta del nuevo directorio*/
    $dir =  $_SESSION['ultimaAccion']['url'] . "/" . $nombre;

    // Intentar crear el directorio $dir
    if (ftp_mkdir($id_ftp, $dir)) {
        echo "Creada con éxito";
    } else {
        echo "Ha habido un problema";
    }

    // Close the connection
    ftp_close($conn_id);
}




