<?php

session_start();
include('../../php/bbdd/ftp-bbdd.php');


if ($_SESSION['ultimaAccion']['localoftp'] == "local") {
    copy($_FILES['archivo']['tmp_name'], $_SESSION['localurl'] . "/" . $_FILES['archivo']['name']);
} else {
    /* Cogemos la ruta actual para saber en que ftp y ruta crear la carpeta */
    $idftp = $_SESSION['ultimaAccion']['idftp'];

    $ftp = FTP::verFTP($idftp);
    $url = $_SESSION['ultimaAccion']['url'];

    define("SERVER", $ftp['url']); //IP o Nombre del Servidor
    define("PORT", $ftp['port']); //Puerto
    define("USER", $ftp['nick']); //Nombre de Usuario
    define("PASSWORD", $ftp['pass']); //Contraseña de acceso
    define("PASV", true); //Activa modo pasivo
    
    /*Conexion a ftp*/
    $id_ftp = ftp_connect(SERVER, PORT); //Obtiene un manejador del Servidor FTP
    ftp_login($id_ftp, USER, PASSWORD); //Se loguea al Servidor FTP
    ftp_pasv($id_ftp, PASV); //Establece el modo de conexión
    
    ftp_put($id_ftp,$url."/".$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name'], FTP_BINARY);
    //Sube un archivo al Servidor FTP en modo Binario
    ftp_quit($id_ftp); //Cierra la conexion FTP
}   