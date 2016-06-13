<?php

require_once("../bbdd/ftp-bbdd.php");
// Desactivar toda notificación de error
error_reporting(0);

session_start();
$idftp = $_POST['idftp'];   
$lista = FTP::borrarFTP($idftp);
