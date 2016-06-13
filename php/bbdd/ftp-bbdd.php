<?php

require_once("bd.php");


class FTP extends db {

    protected $idFTP;
    protected $server;
    protected $user;
    protected $pass;
    protected $port;
    protected $pasv;
    protected $iduser;

    public function __construct($server, $port, $user, $pass,$pasv,$iduser) {
        $this->server = $server;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->pasv = $pasv;
        $this->iduser = $iduser;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function registrarFTP() {
        $dbpadre = new db();
        $campos = "url,nick,pass,port,pasv,iduser";
        $valores = array($this->server,$this->user,$this->pass,$this->port, $this->pasv,$this->iduser);
        return $dbpadre->insert("ftp", $campos, $valores, "?,?,?,?,?,?");
    }
    public static function verFTP($idftp) {
        $dbpadre = new db();
        $campo = "idftp";
        $valor = $idftp;
        return $resultado = $dbpadre->select("ftp", "*", $campo, $valor);
    }

    public function consultarFTP() {
        $dbpadre = new db();
        $campo = "iduser";
        $valor = $this->iduser;
        return $resultado = $dbpadre->selectM("ftp", "*", $campo, $valor);
    }

    public static function borrarFTP($idftp){
        $dbpadre = new db();
        $campo = "idftp";
        $valor = $idftp;
        $dbpadre->delete("ftp",$campo, $valor);
    }
}
?>