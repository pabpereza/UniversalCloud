
/*******  AJAX archivos ftp *****/


function mostrarFormularioFTP() {
    if (document.getElementById("add-ftp").classList.contains('ftp-cerrado')) {
        document.getElementById("add-ftp").classList.remove("ftp-cerrado");
        document.getElementById("add-ftp").classList.add("ftp-abierto");
    } else {
        document.getElementById("add-ftp").classList.remove("ftp-abierto");
        document.getElementById("add-ftp").classList.add("ftp-cerrado");
    }
    document.getElementById('formulario-add-ftp').addEventListener('submit', registroFTP);
}


/*Funcion para añadir el registro FTP a la base de datos*/
function registroFTP(ev) {

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/ftp/compConectFTP.php", true);

    /*Añadir efecto de carga*/
    document.getElementById("explorer-content").innerHTML = "<img id='efecto-carga' src='images/carga.gif'> ";

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            document.getElementById("resultado-registro-ftp").innerHTML = oReq.responseText;
            actualizarListaFTP();
            document.getElementById("formulario-add-ftp").reset();
            setTimeout(function () {
                document.getElementById("resultado-registro-ftp").innerHTML = "";
            }, 2000);
        } else {
            document.getElementById("resultado-registro-ftp").innerHTML = oReq.responseText;
            actualizarListaFTP();
        }
    };


    oReq.send(new FormData(document.getElementById("formulario-add-ftp")));
    ev.preventDefault();


}

/* Funcion para cerra y eliminar un FTP de la base de datos*/
function cerrarFTP(idftp) {
    var oReq = new XMLHttpRequest();

    datos = "idftp=" + idftp;
    oReq.open("POST", "php/ftp/cerrarFTP.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            actualizarListaFTP();
            mostrarArchivosLocales();
        } else {
            actualizarListaFTP();
            mostrarArchivosLocales();
        }
    };
    console.log(datos);
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);
}




