<?php
include('../../php/bbdd/ftp-bbdd.php');
session_start();

$opcion = $_POST['opcion'];
if(isset($_POST['ruta'])){
    $path = $_POST['ruta'];
}
?>
<h2 class="opciones">Copiar en...</h2>
<?php
if ($opcion == "local") {
    if (!isset($path)) {
        $path = "../../CloudFiles/" . $_SESSION['usuario']['idusuarios'];
    }
    $d = dir($path);
    if (!$d)
        return false;

    while (false !== ($current = $d->read())) {
        if ($current === '.' || $current === '..')
            continue;

        $file = $d->path . '/' . $current;
        if (is_dir($file)) {
            ?>
            <div  id='dirnav' name='dirnav' ><i class="fa fa-folder" aria-hidden="true" onclick="listarOpciones('<?php echo $opcion ?>', '<?php echo $path . "/" . $current ?>',<?php echo "this" ?>)"></i>&nbsp;<span id="texto-dirnav" onclick="copiado('<?php echo $path . "/" . $current ?>')"> <?php echo $current ?></span></div>
            <?php
        }
    }

    $d->close();
    return true;
} else {
    /* Cogemos la ruta actual para saber en que ftp y ruta crear la carpeta */

    $idftp = $opcion;


    $ftp = FTP::verFTP($idftp);

    define("SERVER", $ftp['url']); //IP o Nombre del Servidor
    define("PORT", $ftp['port']); //Puerto
    define("USER", $ftp['nick']); //Nombre de Usuario
    define("PASSWORD", $ftp['pass']); //Contraseña de acceso
    define("PASV", true); //Activa modo pasivo

    $id_ftp = ftp_connect(SERVER, PORT); //Obtiene un manejador del Servidor FTP
    ftp_login($id_ftp, USER, PASSWORD); //Se loguea al Servidor FTP
    ftp_pasv($id_ftp, PASV); //Establece el modo de conexión

    if (!isset($path)) {
        $path = ftp_pwd($id_ftp);
    }


    $listado = ftp_nlist($id_ftp, $path);


    foreach ($listado as $actual) {
        $tamano = ftp_size($id_ftp, $actual);

        $auxEx = explode("/", $actual);
        $nombre = end($auxEx);

        if ($tamano < 1) {
            ?>
            <div id='dirnav' name='dirnav'><i class="fa fa-folder" aria-hidden="true" onclick="listarOpciones('<?php echo $opcion ?>','<?php echo $actual ?>',<?php echo "this" ?>)"></i>&nbsp;<span id="texto-dirnav"  onclick="copiado('<?php echo $actual ?>')"> <?php echo $nombre ?></span></div>
            <?php
        }
    }
}


  
  
