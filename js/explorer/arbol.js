
var desplegado = false;
document.getElementById("arbol").addEventListener("click", desplegarArbol);

function desplegarArbol(accion) {
    anchura = window.innerWidth / 4;
    if (desplegado) {
        //Se cierra
        document.getElementById("sidebar-right").style.left = document.getElementById("sidebar-right").offsetLeft + anchura + "px";
        document.getElementById("explorer-content").style.width = document.getElementById("explorer-content").offsetWidth + anchura + "px";
        document.getElementById("arbol").style = "";
        desplegado = false;
    } else {
        //Se abre
        document.getElementById("sidebar-right").style.left = document.getElementById("sidebar-right").offsetLeft - anchura + "px";
        document.getElementById("explorer-content").style.width = document.getElementById("explorer-content").offsetWidth - anchura + "px";
        document.getElementById("arbol").style = "background-color: #4282c4;color:white;";

        desplegado = true;
        listarNavegador();
    }
}

function listarNavegador(ruta, objetivo) {
    if (desplegado) {
        if (ruta == undefined) {
            /*Añadir efecto de carga*/
            document.getElementById("sidebar-right-content").innerHTML = "<img id='efecto-carga-sidebar' src='images/carga.gif'> ";

            var oReq = new XMLHttpRequest();
            oReq.open("POST", "php/navigator/listarActual.php", true);

            oReq.onload = function (oEvent) {
                if (oReq.status == 200) {
                    document.getElementById("sidebar-right-content").innerHTML = oReq.responseText;
                }
            };
            oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oReq.send();
        } else {

            /*Datos a enviar*/
            datos = "ruta=" + ruta;

            //Cambiar icono carpeta y eliminar el evento
            objetivo.setAttribute("class", "fa fa-folder-o");
            objetivo.setAttribute("onclick", " ");

            /*Añadir efecto de carga*/
            objetivo.innerHTML += "<img id='efecto-carga-sidebar-folder' src='images/carga.gif' height='20' width='20'> ";


            var oReq = new XMLHttpRequest();
            oReq.open("POST", "php/navigator/listarActual.php", true);

            oReq.onload = function (oEvent) {
                if (oReq.status == 200) {
         
                    objetivo.parentNode.innerHTML += oReq.responseText;
                     document.getElementById("efecto-carga-sidebar-folder").remove();
                }

            };
            oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oReq.send(datos);
        }
    }
}


