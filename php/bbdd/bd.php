<?php
require_once('config.php');


class db {
    protected $link; //enlace con la conexion
    protected $campos=array();
    protected $where=array();
    protected $db;
    protected $tabla;
    private $tipoconsulta;
    private $sentencia;
    private $resultado=null;
    
    public function db(){                      
    }
    
    
    public function __set($propiedad, $valor){
        
        $this->$propiedad=$valor;            
    }
    public function __get($propiedad){
        
        return $this->$propiedad;
    }
    public function connect(){
        
        
    }
    public function __call($metodo, $argumentos){
    }
    
    function insert($tabla,$campos,$valores,$intrg){
        //Conexion 
        $gbd = self::conexion();

        //Ejecucion de la sentencia
        $sql = "insert into ".$tabla." (".$campos.") values ($intrg)";
        $sth = $gbd->prepare($sql); 
        $sth->execute($valores);
        $gbd = null;
    }

    function delete($tabla,$campo,$valor){
        //Configuracion
        $gbd = self::conexion();
                
        //Preparamos un array
        $varray = array($valor);
        
        //Ejecucion de la sentencia
        $sql = "delete from ".$tabla." WHERE ".$campo." = ?" ;
        $sth = $gbd->prepare($sql);   
        $sth->execute($varray);
        $gbd = null;    
    }

    function update($tabla,$campos,$valores,$campoWhere,$valorWhere){
        //Conexion 
        $gbd = self::conexion();
     
        //Ejecucion de la sentencia
        $sql = "UPDATE ".$tabla." SET ".$campos." WHERE ".$campoWhere."= ".$valorWhere;
      
        $sth = $gbd->prepare($sql); 
        var_dump($sth);
        $sth->execute($valores);
        $gbd = null;  
    }

    function select($tabla,$selecion,$campo,$valor){
        //Configuracion
        $gbd = self::conexion();
        
 
       
        //Ejecucion de la sentencia
        $sql = "select ".$selecion." from ".$tabla." WHERE ".$campo." = ?" ;
        $sth = $gbd->prepare($sql);  

        $sth->execute(array($valor));
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
        $gbd = null;      
    }
    
    function selectM($tabla,$selecion,$campo,$valor){
        //Configuracion
        $gbd = self::conexion();

        //Preparamos un array
        $varray = array($valor);

        //Ejecucion de la sentencia
        $sql = "select ".$selecion." from ".$tabla." WHERE ".$campo." = ?" ;
        $sth = $gbd->prepare($sql);   
        $sth->execute($varray);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        $gbd = null;      
    }
    
    function selectT($tabla){
        //Configuracion
        $gbd = self::conexion();
        
        //Ejecucion de la sentencia
        $sql = "select * from ".$tabla ;
        $sth = $gbd->prepare($sql);   
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        $gbd = null;      
    }
    
    public function conexion(){
        $objConf = new config();
        return new PDO('mysql:host='.$objConf->host.';dbname='.$objConf->db,$objConf->user,$objConf->clave);
    }
    
    public function ultimaAI(){
        //Configuracion
        $gbd = self::conexion();
        $resultado = null;
        $sql="SELECT id_usuario +1 FROM usuario order by id_usuario DESC limit 1";
        $gsent = $gbd->prepare($sql);
  
        $gsent->execute();
        $resultado= $gsent->fetchAll(PDO::FETCH_NUM);
        $gdb=null;

        if($resultado[0]==null){
            $resultado[0]=0;
        }
        return $resultado[0];
    }
}

//$dbpadre = new db();

//TestDelete
//$campos = "nick";
//$valores = "strike";
//$dbpadre->delete("usuario",$campos,$valores);

//TestSelect
//$campo = "nick";
//$valor = "'strike'";
//$dbpadre->select("usuario","*",$campo,$valor);

?>