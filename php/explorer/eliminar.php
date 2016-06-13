<?php

$nombre = $_POST['nombre'];
include('../../php/bbdd/ftp-bbdd.php');

session_start();


if ($_SESSION['ultimaAccion']['localoftp'] == "local") {
    if (is_dir($nombre)) {
        borrarDirectorio($nombre);
    } else {
        unlink($nombre);
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

    $tamano = ftp_size($id_ftp, $nombre);

    if ($tamano < 1) {
        borrarDirectorioFTP($nombre, $id_ftp);
    } else {
        ftp_delete($id_ftp, $nombre);
    }
}

function borrarDirectorio($path) {
    $path = rtrim(strval($path), '/');

    $d = dir($path);

    if (!$d)
        return false;

    while (false !== ($current = $d->read())) {
        if ($current === '.' || $current === '..')
            continue;

        $file = $d->path . '/' . $current;

        if (is_dir($file))
            borrarDirectorio($file);

        if (is_file($file))
            unlink($file);
    }

    rmdir($d->path);
    $d->close();
    return true;
}

function borrarDirectorioFTP($path, $id_ftp) {

    $listado = ftp_nlist($id_ftp, $path);

    foreach ($listado as $actual) {
        $tamano = ftp_size($id_ftp, $path);

        if ($tamano < 1) {
            borrarDirectorioFTP($actual, $id_ftp);
        } else {
            ftp_delete($id_ftp, $actual);
        }
    }
    
    ftp_rmdir($id_ftp, $path);
    return true;
}
