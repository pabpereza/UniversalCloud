document.oncontextmenu = function () {
    return false
};
document.getElementById("explorer-content").addEventListener("mousedown", seleccion);



/*Estilos menu secundario*/
estiloAbierto = "position: fixed; display: block; width: 137px; height: 161px; background-color: rgba(212,212,212,0.98); z-index:9999; opacity:0.9; transition: .2s linear !important; border:1px solid grey; ";
estiloCerrado = "position: fixed; width: 0px; height: 0px; opacity:0; z-index: -1; top:inherit; left:inherit; transition:none;";
menuSecundario = document.getElementById("menuSecundario");

/*Ocultamos el menu al inicio*/
menuSecundario.style = estiloCerrado;

/*Variable para controlar si el menu esta abierto o no*/

var objetivo;
abierto = false;

function seleccion(e) {
    if (e.button == 2 && abierto == false) {
        objetivo = e.target;

        if (objetivo.id != "explorer-content") {
            if (objetivo.id == "imagen" || objetivo.id == "nombre" || objetivo.id == "tamaño" || objetivo.id == "fechaM") {
                objetivo = objetivo.parentNode;
            } else {
                if (objetivo.getAttribute("class") == "extension") {
                    objetivo = objetivo.parentNode;
                    objetivo = objetivo.parentNode;
                }
            }

            if (objetivo.childNodes[3].innerHTML != "Dir Padre") {
                abierto = true;
                x = e.clientX;
                y = e.clientY;
                menuSecundario.style = estiloAbierto;
                menuSecundario.style.top = y;
                menuSecundario.style.left = x;
                agregarFuncionalidad();
                objetivo.style = " -webkit-filter: saturate(2);";
            }
        }
    } else {
        if (objetivo != undefined) {
            if (objetivo.id != "explorer-content") {

                objetivo.style = "initial";
            }
        }
        menuSecundario.style = estiloCerrado;
        abierto = false;
    }
}


function agregarFuncionalidad() {
    document.getElementById("sm-eliminar").addEventListener("click", eliminar);
    document.getElementById("sm-renombrar").addEventListener("click", renombrar);
    document.getElementById("sm-descargar").addEventListener("click", descargar);
    document.getElementById("sm-copiar").addEventListener("click", copiar);
}


/*#######################################################*/
/*           FUNCIONES MENU SECUNDARIO*/
var rutaOrigen;
function copiar(e) {
    rutaOrigen = objetivo.lastChild.previousSibling.value;

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/navigator/mostrarOpciones.php", true);
    if (!desplegado) {
        desplegarArbol();

    }
    seleccion(e);
    oReq.onload = function (oEvent) {
        document.getElementById("sidebar-right-content").innerHTML = oReq.responseText;
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send();
}


function listarOpciones(opcion, ruta, objetivo) {
    console.log(opcion);
    datos = "opcion=" + opcion + "&ruta" + ruta;

    if (desplegado) {
        if (ruta == undefined) {
            /*Añadir efecto de carga*/
            document.getElementById("sidebar-right-content").innerHTML = "<img id='efecto-carga-sidebar' src='images/carga.gif'> ";

            var oReq = new XMLHttpRequest();
            oReq.open("POST", "php/navigator/listarOpciones.php", true);

            oReq.onload = function (oEvent) {
                if (oReq.status == 200) {
                    document.getElementById("sidebar-right-content").innerHTML = oReq.responseText;
                }
            };
            oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oReq.send(datos);
        } else {

            //Cambiar icono carpeta y eliminar el evento
            objetivo.setAttribute("class", "fa fa-folder-o");
            objetivo.setAttribute("onclick", " ");

            /*Añadir efecto de carga*/
            objetivo.innerHTML += "<img id='efecto-carga-sidebar-folder' src='images/carga.gif' height='20' width='20'> ";


            var oReq = new XMLHttpRequest();
            oReq.open("POST", "php/navigator/listarOpciones.php", true);

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
function copiado(destino) {
    datos = "origen=" + rutaOrigen + "&destino=" + destino;
    console.log(datos);
    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/explorer/copiar.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            document.getElementById("explorer-content").innerHTML += oReq.responseText;
            desplegarArbol();
        }
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);

}



function eliminar(e) {
    nombre = objetivo.lastChild.previousSibling.value;

    datos = "nombre=" + nombre;

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/explorer/eliminar.php", true);
    document.getElementById("explorer-content").innerHTML = "<img id='efecto-carga' src='images/carga.gif'> ";
    seleccion(e);
    oReq.onload = function (oEvent) {
        //document.getElementById("explorer-content").innerHTML = oReq.responseText;
        refresh();
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);
}

function renombrar(e) {
    ruta = objetivo.lastChild.previousSibling.value;
    nombre = prompt('Ingrese el nuevo nombre junto con su formato:', '');
    datos = "nombre=" + nombre + "&ruta=" + ruta;

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/explorer/renombrar.php", true);
    document.getElementById("explorer-content").innerHTML = "<img id='efecto-carga' src='images/carga.gif'> ";
    seleccion(e);
    oReq.onload = function (oEvent) {
        //document.getElementById("explorer-content").innerHTML = oReq.responseText;
        refresh();
    };
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(datos);
}
function descargar(e) {
    ruta = objetivo.lastChild.previousSibling.value;
    datos = "ruta=" + ruta;

    window.open("php/explorer/descargar.php?ruta=" + ruta, "width=100,height=100,left=5000,top=5000");

    seleccion(e);
    refresh();
    oReq.send(datos);
}
/*          FIN FUNCIONES MENU SECUNDARIO*/
/*#######################################################*/