
<?php
include('ftpfunc.php'); //Incluye el archivo de funciones
session_start();
// Desactivar toda notificación de error
error_reporting(0);

$idftp = $_POST['idftp'];
$ftp = FTP::verFTP($idftp);

/* Si no se a creado la session de las url de las ftp se crea de nuevo */
if (!isset($_SESSION['cloudurl'][$idftp])) {
    $_SESSION['cloudurl'][$idftp] = "";
}

# FUNCIONES FTP
# 
# CONSTANTES 
define("SERVER", $ftp['url']); //IP o Nombre del Servidor
define("PORT", $ftp['port']); //Puerto
define("USER", $ftp['nick']); //Nombre de Usuario
define("PASSWORD", $ftp['pass']); //Contraseña de acceso
define("PASV", true); //Activa modo pasivo


/* Comprueba si la variable "archivo" se ha definido */
if (!empty($_POST["archivo"])) {
    SubirArchivo($_POST["archivo"], basename($_POST["archivo"]));
    //basename obtiene el nombre de archivo sin la ruta
    unset($_POST["archivo"]); //Destruye la variable "archivo"
}

/* Conexcion y obtencion de ruta */
$id_ftp = ConectarFTP();


if (isset($_POST["ruta"])) {
    $ruta = $_POST["ruta"];
} else if (isset($_SESSION['cloudurl'][$idftp])) {
    $ruta = $_SESSION['cloudurl'][$idftp];
} else {
    $ruta = ObtenerRuta();
}

/* Guardar ruta actual en la session */
$_SESSION['cloudurl'][$idftp] = $ruta;


/* Guardamos la ultima accion en una variable de sesion para saber a quien tiene
  que realizar la accion los distintos metodos */
$_SESSION['ultimaAccion']['localoftp'] = "ftp";
$_SESSION['ultimaAccion']['idftp'] = $idftp;
$_SESSION['ultimaAccion']['url'] = $ruta;



$lista = ftp_nlist($id_ftp, $ruta); //Devuelve un array con los nombres de ficheros
$lista = array_reverse($lista); //Invierte orden del array (ordena array)


/*Obtener la ruta del directorio padre*/
$rutaPadre = "";
$trimAux = explode("/",$ruta);
unset($trimAux[count($trimAux)-1]);
$rutaPadre = implode("/",$trimAux);
$rutaPadre = "/".$rutaPadre;
    

?>
<div id='directorios' class="directorios" onclick="mostrarArchivosFTP('<?php echo $rutaPadre . "'," . $idftp ?>)">
    <div id='imagen' class='dir'></div>
    <div id='nombre'>Dir Padre</div>
    <div id='tamaño'>&nbsp;</div>
    <div id='fechaM'>&nbsp;</div>
</div> 
<?php

while ($item = array_pop($lista)) { //Se leen todos los ficheros y directorios del directorio
    //$tamano = number_format(((ftp_size($id_ftp, $item)) / 1024), 2) . " Kb";
    $tamano = FileSizeConvert(ftp_size($id_ftp, $item));
    //$tamano = ftp_size($id_ftp, $item);
    //Obtiene tamaño de archivo y lo pasa a KB
    if ($tamano < 1) { // Si es -0.00 Kb se refiere a un directorio
        $dirORfil = "dir";
        $tamano = "&nbsp;";
        $fecha = "&nbsp;";
    } else {
        $dirORfil = "fil";
        $fecha = date("d/m/y h:i:s", ftp_mdtm($id_ftp, $item));
        //Filemtime obtiene la fecha de modificacion del fichero; y date le da el formato de salida
    }



    /* Conseguir nombre del directorio */
    $auxEx = explode("/", $item);
    $nombre = end($auxEx);

    $extension = "";
    /* Separa Extension y nombre */
    if ($dirORfil == "fil") {

        $aux = explode(".", $nombre);
        $nombre = $aux[0];
        if (isset($aux[1])) {
            if (strlen($aux[1]) <= 4) {
                $extension = $aux[1];
            }
        }
    }
    ?>

    <div id='directorios' class="directorios" onclick="mostrarArchivosFTP('<?php
    if ($dirORfil == "dir") {
        echo $item . "'," . $idftp;
    };
    ?>)">
        <div id='imagen' class='<?php echo $dirORfil ?>'><div class="extension"><?php echo $extension ?></div></div>
        <div id='nombre' class="nombreb"><?php echo $nombre ?></div>
        <div id='tamaño'><?php echo $tamano ?></div>
        <div id='fechaM'><?php echo $fecha ?></div>
        <input type="hidden" id="url" value="<?php echo $item ?>">
    </div> 
    <?php
}

function FileSizeConvert($bytes) {
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );

    $result = "";
    foreach ($arBytes as $arItem) {
        if ($bytes >= $arItem["VALUE"]) {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
            break;
        }
    }
    return $result;
}
