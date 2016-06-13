<?php
include('../../php/bbdd/ftp-bbdd.php');


$nombre = $_POST['nombre'];
$ruta = $_POST['ruta'];

session_start();
$rutaparcial = $_SESSION['ultimaAccion']['url'];

if ($_SESSION['ultimaAccion']['localoftp'] == "local") {
        rename($ruta,$rutaparcial."/".$nombre);
} else {
    /* Cogemos la ruta actual para saber en que ftp y ruta crear la carpeta */
    $idftp = $_SESSION['ultimaAccion']['idftp'];

    $ftp = FTP::verFTP($idftp);

    define("SERVER", $ftp['url']); //IP o Nombre del Servidor
    define("PORT", $ftp['port']); //Puerto
    define("USER", $ftp['nick']); //Nombre de Usuario
    define("PASSWORD", $ftp['pass']); //Contraseña de acceso
    define("PASV", true); //Activa modo pasivo
    
    $id_ftp = ftp_connect(SERVER, PORT); //Obtiene un manejador del Servidor FTP
    ftp_login($id_ftp, USER, PASSWORD); //Se loguea al Servidor FTP
    ftp_pasv($id_ftp, PASV); //Establece el modo de conexión

    ftp_rename($id_ftp,$ruta,$rutaparcial."/".$nombre);
}