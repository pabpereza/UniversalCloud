<?php

require_once("../bbdd/ftp-bbdd.php");

$server = $_POST['server'];
$port = $_POST['port'];
$user = $_POST['user'];
$password = $_POST['password'];
error_reporting(0);

session_start();
$iduser = $_SESSION['usuario']['idusuarios'];

# CONSTANTES 
define("SERVER", $server); //IP o Nombre del Servidor
define("PORT", $port); //Puerto
define("USER", $user); //Nombre de Usuario
define("PASSWORD", $password); //Contraseña de acceso
define("PASV", true); //Activa modo pasivo

# FUNCIONES
//Permite conectarse al Servidor FTP
$id_ftp = ftp_connect(SERVER, PORT); //Obtiene un manejador del Servidor FTP
$rLogin = ftp_login($id_ftp, USER, PASSWORD); //Se loguea al Servidor FTP
ftp_pasv($id_ftp, PASV); //Establece el modo de conexión



/*Comprobar que los datos de la FTP son correctos*/
if (!$id_ftp) {
    ftp_close($id_ftp);
    echo 'No se puede conectar al servidor FTP, compruebe el nombre del servidor';
} else if (!$rLogin) {
    ftp_close($id_ftp);
    echo 'No se puede conectar al servidor FTP, compruebe el nombre de usuario y la contraseña';
} else {
    $ftp = new FTP($server, $port, $user, $password, PASV, $iduser);
    $ftp->registrarFTP();
    echo 'Se ha añadido correctamente la FTP';
}
