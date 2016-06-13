<?php

class config{
    
    public $db = '';
    public $user = '';
    public $clave = '';
    public $host = '';
    public function __construct($db = 'unicloud',$host='localhost',$user='root',$clave='1512101asdf'){
        $this->db =$db;
        $this->user =$user;
        $this->clave=$clave;
        $this->host=$host;
    }
}

?>