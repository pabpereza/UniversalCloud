

function actualizarListaFTP() {
    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/ftp/actualizarFTP.php", true);

     /*Añadir efecto de carga*/
    document.getElementById("explorer-content").innerHTML = "<img id='efecto-carga' src='images/carga.gif'> ";   

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
         
            document.getElementById("sidebar-left").innerHTML = oReq.responseText;
            mostrarArchivosLocales();
        } else {
            document.getElementById("sidebar-left").innerHTML = oReq.responseText;
            mostrarArchivosLocales();
        }
    };

    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(new FormData(document.getElementById("formulario-add-ftp")));
    
}

