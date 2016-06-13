<?php
require_once("../bbdd/ftp-bbdd.php");

// Desactivar toda notificación de error
error_reporting(0);

session_start();
$iduser = $_SESSION['usuario']['idusuarios'];
$ftp = new FTP("", "", "", "", "", $iduser);
$lista = $ftp->consultarFTP();

unset($ftp);
?>
  <div id="sidebar-left-buttons">
    <div id="buscador">
      <input type="text" id="input-buscador" placeholder="Buscador" onkeyup="buscador()">
    </div>
    <div id="close-open-bar"><img src="images/menu.png" height="20px" width="25px"></div>

  </div>
  <div class="sidebar-left-button activa" id="local-files" onclick=" mostrarArchivosLocales()">
    <div id="locales-text">Archivos Cloud</div>
    <div class="img"><img src="images/home.png" height="27px" width="27px"></div>
  </div>


  <?php
if ($lista != null) {
    if (is_array($lista[0])) {
        foreach ($lista as $item) { //Se leen todos los ficheros y directorios del directorio
            ?>
    <div class="sidebar-left-button ftp" id="ftp-files-<?php echo $item['idftp'] ?>" onclick="listarFTP(<?php echo $item['idftp'] ?>)">
      <div class="img-close" onclick="cerrarFTP(<?php echo $item['idftp'] ?>)"><i class="fa fa-times" aria-hidden="true"></i></div>
      <p>
        <?php echo sacarNombre($item['url']); ?>
      </p>
      <div class="img"><img src="http://www.google.com/s2/favicons?domain=<?php echo transformarUrl($item['url'])?>" height="22px" width="22px"></div>
    </div>
    <?php
        };
    } else {
        ?>
      <div class="sidebar-left-button ftp" id="ftp-files-<?php echo $item['idftp'] ?>" onclick="listarFTP(<?php echo $item['idftp'] ?>)">
        <div class="img-close" onclick="cerrarFTP(<?php echo $item['idftp'] ?>)"><i class="fa fa-times" aria-hidden="true"></i></div>
        <p>
          <?php echo sacarNombre($lista['url']);  ?>
        </p>
        <div class="img"><img src="http://www.google.com/s2/favicons?domain=<?php echo transformarUrl($lista['url'])?>" height="22px" width="22px"></div>
      </div>
      <?php
    }
}

function transformarUrl($url){
    $arrUrl = explode(".", $url);
    $url = "www.".$arrUrl[1].".".$arrUrl[2];
    return $url;
}
function sacarNombre($url){
    $arrUrl = explode(".", $url);
    $url = $arrUrl[1];
    return $url;
}
?>