<?php

require_once("usuario.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$auxUser = Usuario::consultarUsuario($_POST['user']);
if ($auxUser['pass'] == "'" . md5($_POST['pass']) . "'") {
    session_start();
    $_SESSION['usuario'] = $auxUser;
    $path = "../../CloudFiles/".$_SESSION['usuario']['idusuarios'];
    if (!is_dir($path)) {
        mkdir("../../CloudFiles/".$_SESSION['usuario']['idusuarios']);
    }
    echo "true";
    
}else{
    echo "Comprueba tus datos de identificación";
}

//Cerrar Sesion
/*if(isset($_POST['cerrarSesion'])){
    unset($_SESSION['usuario']);
    header('Location: portada.phtml');
}*/

