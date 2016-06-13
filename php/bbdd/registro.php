<?php

require_once("usuario.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_POST['pass'] == $_POST['txtpass']) {
    $usuario = new Usuario($_POST['nombre'], $_POST['nick'], $_POST['email'], md5($_POST['pass']));
    $usuario->registrarUsuario();
    echo "<p style='green'>El registro se ha realizado correctamente</p>";
    $usuario = null;
} else {
    echo "<p style='color:red;'>La clave no coincide, vuelve a intentarlo</p>";
}

