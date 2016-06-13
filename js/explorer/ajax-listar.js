
actualizarListaFTP();
var activa = "local-files";


/************* AJAX archivos en FTP *****************/
function listarFTP(idftp) {

    /*Cambio de la clase activa*/
    document.getElementById(activa).className = document.getElementById(activa).className.replace(/(?:^|\s)activa(?!\S)/g, '');
    document.getElementById("ftp-files-" + idftp).className += " activa";
    activa = "ftp-files-" + idftp;

    /*Mostar herramientas de FTP*/
    //anadirHerramientasFTP();

    /*Añadir efecto de carga*/
    document.getElementById("explorer-content").innerHTML = "<img id='efecto-carga' src='images/carga.gif'> ";
    /*Recogida de datos*/
    datos = "idftp=" + idftp;
    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/ftp/ftp.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            $("efecto-carga").hide(200);
            document.getElementById("explorer-content").innerHTML = oReq.responseText;
            if (lista) {
                listaE();
            }
            if (columnas) {
                columnasE();
            }
        } else {
            document.getElementById("explorer-content").innerHTML = oReq.responseText;
            if (lista) {
                listaE();
            }
            if (columnas) {
                columnasE();
            }
        }
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);
}
function mostrarArchivosFTP(ruta, idftp, dirOfil) {



    /*Recogida de datos*/
    datos = "ruta=" + ruta + "&idftp=" + idftp;
    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/ftp/ftp.php", true);

    /*Añadir efecto de carga*/
    document.getElementById("explorer-content").innerHTML = "<img id='efecto-carga' src='images/carga.gif'> ";


    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            document.getElementById("explorer-content").innerHTML = oReq.responseText;
            if (lista) {
                listaE();
            }
            if (columnas) {
                columnasE();
            }
        } else {
            document.getElementById("explorer-content").innerHTML = oReq.responseText;
            listarNavegador();
            if (lista) {
                listaE();
            }
            if (columnas) {
                columnasE();
            }
        }
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);
}


/*******  AJAX archivos cloud *****/
var SO;

if (navigator.appVersion.indexOf("Linux") != -1) {
    SO = "linux"
} else if (navigator.userAgent.indexOf('Mac') != -1) {
    SO = "macintosh"
} else {
    SO = "windows";
}


function mostrarArchivosLocales(numPath) {

    /*Cambio de la clase activa*/
    document.getElementById(activa).className = document.getElementById(activa).className.replace(/(?:^|\s)activa(?!\S)/g, '');
    document.getElementById("local-files").className += " activa";
    activa = "local-files";

    /*Añadir efecto de carga*/
    document.getElementById("explorer-content").innerHTML = "<img id='efecto-carga' src='images/carga.gif'> ";

    var path;
    if (numPath != undefined) {
        path = numPath;
    }

    datos = "system=" + SO + "&path=" + path;
    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/explorer/archivosLocales.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            document.getElementById("explorer-content").innerHTML = oReq.responseText;
            if (lista) {
                listaE();
            }
            if (columnas) {
                columnasE();
            }
        } else {
            document.getElementById("explorer-content").innerHTML = oReq.responseText;
            quitarCarpetasPunto();
            if (lista) {
                listaE();
            }
            if (columnas) {
                columnasE();
            }
        }
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);
}