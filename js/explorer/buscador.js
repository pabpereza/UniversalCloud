

function buscador() {
    busqueda = document.getElementById("input-buscador").value;
    busqueda = busqueda.toLowerCase(busqueda);

    nombres = document.getElementsByClassName("nombreb");

    for (var i = 0; i < nombres.length; i++) {
        nombres[i].parentNode.style = "display:inline-block";
    }

    for (var i = 0; i < nombres.length; i++) {
        if (nombres[i].innerHTML.toLowerCase().indexOf(busqueda) == -1) {
            nombres[i].parentNode.style = "display:none";
        }
    }
}


