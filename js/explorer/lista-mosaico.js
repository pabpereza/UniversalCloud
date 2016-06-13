var lista = false;
var columnas = false;

document.getElementById("boton-lista").addEventListener("click", listaE);
document.getElementById("boton-mosaico").addEventListener("click", mosaicoE);
document.getElementById("boton-columnas").addEventListener("click", columnasE);


function listaE() {
    $(".directorios").addClass("lista");
    $(".directorios").removeClass("columnas");
    lista = true;
    columnas = false;
}

function mosaicoE() {
    $(".directorios").removeClass("lista");
    $(".directorios").removeClass("columnas");
    lista = false;
    columnas = false;
}

function columnasE() {
    $(".directorios").removeClass("lista");
    $(".directorios").addClass("columnas");
    columnas = true;
    lista = false;
}