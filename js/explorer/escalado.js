candadoA = true;
resize();

function resize() {
    altura = window.innerHeight;
    anchura = window.innerWidth;

    /*Dimensiones top_nav*/
    document.getElementById("top_nav").style.height =
            altura / 15 + "px";



    /*Dimensiones explorer*/
    document.getElementById("explorer").style.height =
            altura * 26.5 / 30 + "px";


    /*Dimensiones bottom_nav*/
    document.getElementById("bottom_nav").style.height =
            altura * 1.5 / 30 + "px";

    /*Dimensiones explorer altura*/

    document.getElementById("sidebar-left").style.height =
            altura * 26.5 / 30 + "px";
    document.getElementById("sidebar-left").style.height =
            altura * 26.5 / 30 + "px";

    document.getElementById("sidebar-right").style.height =
            altura * 26.5 / 30 + "px";

    document.getElementById("explorer-content").style.height =
            altura * 26.5 / 30 + "px";

    /*Dimensiones explorer anchura*/

    document.getElementById("sidebar-left").style.width =
            anchura * 0.20 + "px";
     document.getElementById("sidebar-left").style.left =
            0 + "px";

    document.getElementById("explorer-content").style.width =
            anchura * 0.80 + "px";
    document.getElementById("explorer-content").style.left =
            anchura * 0.20 + "px";
    document.getElementById("sidebar-right").style.width =
            anchura / 4 + "px";
    document.getElementById("sidebar-right").style.left =
            anchura + "px";

    /*Ajuste posicion sidebar-left*/
    document.getElementById("sidebar-left").style.top =
            altura / 15 + "px";
    document.getElementById("explorer-content").style.left =
            anchura * 0.20 + "px";


    /*Tamaño div logo*/
    document.getElementById("logo").style.width =
            anchura * 0.20 + "px";
    document.getElementById("logo").style.height =
            altura / 15 + "px";



    $(".sidebar-left-button").css({
        width: anchura * 0.20 + "px"
    });

}

/*Boton abrir/cerrar sidebar-left*/

setTimeout(function () {
    document.getElementById("close-open-bar").addEventListener("click", desplegable);
}, 2000);





function desplegable() {
    anchura = window.innerWidth/5.8;

    if (candadoA) {
        //Se cierra
        console.log("cerrando");
        document.getElementById("sidebar-left").style.left = document.getElementById("sidebar-left").offsetLeft - anchura +"px";
        document.getElementById("explorer-content").style.width = document.getElementById("explorer-content").offsetWidth +  anchura+"px";
        document.getElementById("explorer-content").style.left = document.getElementById("explorer-content").offsetLeft -  anchura+"px";
        candadoA = false;
    } else {
        //Se abre
        document.getElementById("sidebar-left").style.left = document.getElementById("sidebar-left").offsetLeft + anchura +"px";
        document.getElementById("explorer-content").style.width = document.getElementById("explorer-content").offsetWidth -  anchura+"px";
        document.getElementById("explorer-content").style.left = document.getElementById("explorer-content").offsetLeft +  anchura+"px";
        candadoA = true;
    }
}

