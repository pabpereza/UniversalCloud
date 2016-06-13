<?php

require_once("bd.php");



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Usuario extends db {

    protected $idUsuario;
    protected $nick;
    protected $nombre;
    protected $email;
    protected $clave;

    public function __construct($nombre, $nick, $email, $contrasenia) {
        $this->nick = $nick;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->clave = $contrasenia;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function registrarUsuario() {
        $dbpadre = new db();
        $campos = "nick,pass,email,nombre";
        $valores = array("'" . $this->nick . "'", "'" . $this->clave . "'", "'" . $this->email . "'", "'" . $this->nombre . "'");
        return $dbpadre->insert("usuarios", $campos, $valores, "?,?,?,?");
    }

    public static function consultarUsuario($nick) {
        $dbpadre = new db();
        $campo = "nick";
        $valor = "'".$nick."'";
        return $resultado = $dbpadre->select("usuarios", "*", $campo, $valor);
    }

    public function mostrarUsuario() {
        return "Nick: " . $this->nick . " Nombre: " . $this->nombre . " Email: " . $this->email . " Clave: " . $this->clave;
    }

}



?>