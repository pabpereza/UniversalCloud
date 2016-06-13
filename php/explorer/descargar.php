<?php

include('../../php/bbdd/ftp-bbdd.php');

$ruta = $_GET['ruta'];

$nombre = basename($ruta);
session_start();

if ($_SESSION['ultimaAccion']['localoftp'] == "local") {
    if (is_file($ruta)) {
        // Si es fichero descargarlo normal
        $ctype = "application/octet-stream";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: $ctype");

        header("Content-Disposition: attachment; filename=\"" . basename($ruta) . "\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($ruta));
        readfile("$ruta");
        exit();
    } else {

        $carpeta = $ruta;

        $archivo_final = 'descargas.zip';  // .zip *
        $zip = new ZipArchive();
        if ($zip->open($archivo_final, ZIPARCHIVE::CREATE) != TRUE) {
            die('No se ha podido crear un archivo zip!');
        }
        function archivar($carpeta, $zip) {
            $carpetas = scandir($carpeta);
            foreach ($carpetas as $archivo) {
                if (($archivo == '.') || ($archivo == '..')) {
                  
                } elseif (is_dir($carpeta . '/' . $archivo)) {
                    archivar($carpeta . '/' . $archivo, $zip);
                } else {
                    $zip->addFile($carpeta . '/' . $archivo, $carpeta . '/' . $archivo);
                }
            }
        }
        archivar($carpeta, $zip);
        
        
        // Si es fichero descargarlo normal
        $ctype = "application/octet-stream";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: $ctype");

        header("Content-Disposition: attachment; filename=\"" . basename($ruta) . "\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($ruta));
        readfile("$zip");
        
        $zip->close();
        exit();
    }
} else {
    /* Cogemos la ruta actual para saber en que ftp y ruta crear la carpeta */
    $idftp = $_SESSION['ultimaAccion']['idftp'];

    $ftp = FTP::verFTP($idftp);

    define("SERVER", $ftp['url']); //IP o Nombre del Servidor
    define("PORT", $ftp['port']); //Puerto
    define("USER", $ftp['nick']); //Nombre de Usuario
    define("PASSWORD", $ftp['pass']); //Contraseña de acceso
    define("PASV", true); //Activa modo pasivo

    $id_ftp = ftp_connect(SERVER, PORT); //Obtiene un manejador del Servidor FTP
    ftp_login($id_ftp, USER, PASSWORD); //Se loguea al Servidor FTP
    ftp_pasv($id_ftp, PASV); //Establece el modo de conexión

    ftp_rename($id_ftp, $ruta, $rutaparcial . "/" . $nombre);
}
