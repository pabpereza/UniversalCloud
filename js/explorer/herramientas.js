

document.getElementById("bot-sub-archivo").addEventListener("click", mostrarSubida);


/* #########################################################################  */
/* SECCION UPLOAD*/
/*Desplegar el formulario de subida de archivo*/
function mostrarSubida() {
    if (document.getElementById("upload").classList.contains('upload-cerrado')) {
        document.getElementById("upload").classList.remove("upload-cerrado");
        document.getElementById("upload").classList.add("upload-abierto");
    } else {
        document.getElementById("upload").classList.remove("upload-abierto");
        document.getElementById("upload").classList.add("upload-cerrado");
    }
}


/* Funcion que examina el archivo seleccionado para mostrar posteriormente su informacion*/
function selectedFile() {
    var archivoSeleccionado = document.getElementById("myfile");
    var file = archivoSeleccionado.files[0];
    if (file) {
        var fileSize = 0;
        if (file.size > 1048576)
            fileSize = (Math.round(file.size * 100 / 1048576) / 100).toString() + ' MB';
        else
            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + ' Kb';

        var divfileSize = document.getElementById('fileSize');
        var divfileType = document.getElementById('fileType');
        divfileSize.innerHTML = 'Tamaño: ' + fileSize;
        divfileType.innerHTML = 'Tipo: ' + file.type;

    }
}

/*Funcion que envia por ajax el archivo a un php que hace la carga al servidor del archivo,
 * mientras que rellena la barra de progreso*/
function uploadFile() {

    var url = "php/explorer/subirArchivos.php";
    var archivoSeleccionado = document.getElementById("myfile");
    var file = archivoSeleccionado.files[0];
    var fd = new FormData();
    fd.append("archivo", file);
    var xmlHTTP = new XMLHttpRequest();

    xmlHTTP.upload.addEventListener("progress", progressFunction, false);
    xmlHTTP.onload = function (oEvent) {
        transferCompleteFunction();
    };
    xmlHTTP.addEventListener("error", uploadFailed, false);
    xmlHTTP.addEventListener("abort", uploadCanceled, false);
    xmlHTTP.open("POST", url, true);


    xmlHTTP.send(fd);
}

function progressFunction(evt) {
    var progressBar = document.getElementById("progressBar");
    var percentageDiv = document.getElementById("percentageCalc");
    if (evt.lengthComputable) {
        progressBar.max = evt.total;
        progressBar.value = evt.loaded;
        percentageDiv.innerHTML = Math.round(evt.loaded / evt.total * 100) + "%";
    }
}

function loadStartFunction(evt) {
    alert('Comenzando a subir el archivo');
}

function transferCompleteFunction(evt) {
    alert('Transferencia completa');
    var progressBar = document.getElementById("progressBar");
    var percentageDiv = document.getElementById("percentageCalc");
    progressBar.value = 100;
    percentageDiv.innerHTML = "100%";
    progressBar.value = 0;
    percentageDiv.innerHTML = "0%";
    var divfileSize = document.getElementById('fileSize');
    var divfileType = document.getElementById('fileType');
    divfileSize.innerHTML = 'Tamaño: ';
    divfileType.innerHTML = 'Tipo: ';
    setTimeout(function () {
        mostrarSubida();
        espacioUsado();
        refresh();
    }, 2000);
}

function uploadFailed(evt) {
    alert("Hubo un error al subir el archivo.");
}

function uploadCanceled(evt) {
    alert("La operación se canceló o la conexión fue interrunpida.");
}

/* FIN SECCION UPLOAD*/
/*#####################################################################*/



/*#####################################################################*/
/* SECCION CREAR CARPETA */

document.getElementById("bot-crear-carpeta").addEventListener("click", mostrarCrearCarpeta);

function mostrarCrearCarpeta() {
    if (document.getElementById("carpeta").classList.contains('carpeta-cerrado')) {
        document.getElementById("carpeta").classList.remove("carpeta-cerrado");
        document.getElementById("carpeta").classList.add("carpeta-abierto");
    } else {
        document.getElementById("carpeta").classList.remove("carpeta-abierto");
        document.getElementById("carpeta").classList.add("carpeta-cerrado");
    }
}

function crearCarpeta() {
    nombre = document.getElementById("nombre-carpeta").value;

    /*Nombre de la carpeta*/
    datos = "nombre=" + nombre;

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/explorer/crearCarpeta.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {

            document.getElementById("crear-carpeta-resultado").innerHTML = oReq.responseText;
            document.getElementById("nombre-carpeta").value = "";

            setTimeout(function () {
                document.getElementById("crear-carpeta-resultado").innerHTML = "";
                mostrarCrearCarpeta();
                refresh();
            }, 2000);

        }
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);
}

/* FIN SECCION CREAR CARPETA */
/*#####################################################################*/





/*#####################################################################*/
/* SECCION ACTUALIZAR */
document.getElementById("actualizar").addEventListener("click", refresh);
function refresh() {
    document.getElementsByClassName("activa")[0].click();
    espacioUsado();
}

/* FIN SECCION ACTUALIZAR */
/*#####################################################################*/


/*#####################################################################*/
/* SECCION RAIZ */
document.getElementById("raiz").addEventListener("click", raiz);

function raiz() {
    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/explorer/raiz.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            refresh();
        }
    };
    oReq.send();
}

/* FIN SECCION RAIZ */
/*#####################################################################*/


/*#####################################################################*/
/* SECCION RAIZ */
espacioUsado();

function espacioUsado() {
    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/explorer/tamañoOcupado.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            document.getElementById("espacio-usado").innerHTML = "Espacio usado: "+ oReq.responseText +" de 1GB";
        }
    };
    oReq.send();
}

/* FIN SECCION RAIZ */
/*#####################################################################*/