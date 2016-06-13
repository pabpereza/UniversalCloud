<?php
require_once("../bbdd/ftp-bbdd.php");

session_start();
$iduser = $_SESSION['usuario']['idusuarios'];
$ftp = new FTP("", "", "", "", "", $iduser);
$lista = $ftp->consultarFTP();

unset($ftp);
?>
<h2 class="opciones">Copiar en...</h2>
<div class="opciones"  onclick="listarOpciones('local')">
    Archivos Cloud
</div>
<?php
if ($lista != null) {
    if (is_array($lista[0])) {

        foreach ($lista as $item) { //Se leen todos los ficheros y directorios del directorio
            ?>
            <div class="opciones" id="ftp-files-<?php echo $item['idftp'] ?>" onclick="listarOpciones(<?php echo $item['idftp'] ?>)">
                <?php echo sacarNombre($item['url']); ?>
            </div>
            <?php
        };
    } else {
        ?>
        <div class="opciones" id="ftp-files-<?php echo $item['idftp'] ?>" onclick="listarOpciones(<?php echo $lista['idftp'] ?>)">
            <?php echo sacarNombre($lista['url']); ?>
        </div>
        <?php
    }
}

function transformarUrl($url) {
    $arrUrl = explode(".", $url);
    $url = "www." . $arrUrl[1] . "." . $arrUrl[2];
    return $url;
}

function sacarNombre($url) {
    $arrUrl = explode(".", $url);
    $url = $arrUrl[1];
    return $url;
}
?>