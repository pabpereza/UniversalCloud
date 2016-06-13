<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$so = $_POST['system'];
$path = "";

//Asignacion de la ruta segun la navegacion o la anterior ruta de la session
if (isset($_POST['path'])) {
    if ($_POST['path'] != "undefined") {
        $path = $_POST['path'];
    } else {
        if (isset($_SESSION['localurl'])) {
            $path = $_SESSION['localurl'];
        } else {
            $path = "../../CloudFiles/" . $_SESSION['usuario']['idusuarios'];
        }
    }
}
$_SESSION['localurl'] = $path;
$array = null;


/* Guardamos la ultima accion en una variable de sesion para saber a quien tiene
  que realizar la accion los distintos metodos */
$_SESSION['ultimaAccion']['localoftp'] = "local";
$_SESSION['ultimaAccion']['idftp'] = "";
$_SESSION['ultimaAccion']['url'] = $path;

//Comprobar si el directorio existe
if (is_dir($path)) {
    $dir = opendir($path);

//Guardamos en un array el contenidos del directorio
    $contador = 0;
    while ($elemento = readdir($dir)) {
        $array[$contador] = $elemento;
        $contador++;
    }
    $array = array_reverse($array);
    if ($contador < 3) {
        echo "<span class='vacio'>Esta carpeta esta vacía</span>";
        $array = null;
    }

//Cerramos el directorio
    closedir($dir);

//Si esta en el directorio raiz del usuario no mostar la carpeta para ir al directorio padre    
    if ($path != "../../CloudFiles/" . $_SESSION['usuario']['idusuarios']) {
        ?>


        <!--   Mostrar directorio padre-->
        <div id='directorios' class="directorios" onclick="mostrarArchivosLocales('<?php echo dirname($path) ?>')">
            <div id='imagen' class='dir'></div>
            <div id='nombre'>Dir Padre</div>
            <div id='tamaño'></div>
            <div id='fechaM'></div>

        </div> 
        <?php
    }
//    Mostrar los archivos del directorio actual
    for ($i = 0; $i < count($array) && $array != null; $i++) {
        $pathI = $path . "/" . $array[$i];
        $dirORfil;

        /* Distinguir directorio o fichero */
        if (is_dir($pathI)) {
            $dirORfil = "dir";
        } else {
            $dirORfil = "fil";
        }

        /* Darle formato al tamaño y la fecha de modificacion */
        $fecha = date("F d Y H:i:s.", filectime($pathI));
        $tamaño = FileSizeConvert(filesize($pathI));
        if ($tamaño == "4 KB") {
            $tamaño = "";
        }
        $nombre = $array[$i];
        $extension = "";
        /* Extraer formato y pulir nombre */
        if ($dirORfil == "fil") {
            $aux = explode(".", $array[$i]);
            $nombre = $aux[0];
            if (isset($aux[1])) {

                $extension = $aux[1];
            }
        }

        /* Compprobacion para eliminar las carpetas . y .. */
        if ($array[$i] != "." && $array[$i] != "..") {



            /* Directorios maquetados */
            ?> 
            <div id='directorios' class="directorios" <?php if ($dirORfil == "dir") { ?> onclick="mostrarArchivosLocales('<?php echo $path . "/" . $array[$i]; ?>')" <?php } ?> >
                <div id='imagen' class='<?php echo $dirORfil ?>'><div class="extension"><?php echo $extension ?></div></div>
                <div id='nombre' class="nombreb"><?php echo $nombre ?></div>
                <div id='tamaño'><?php echo $tamaño ?></div>
                <div id='fechaM'><?php echo $fecha ?></div>
                <input type="hidden" id="url" value="<?php echo $path . "/" . $array[$i]; ?>">
            </div> 
            <?php
        }
    }
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
?>

