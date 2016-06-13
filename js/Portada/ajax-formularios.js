/*******  AJAX Formulario Registro *****/
var form = document.forms.namedItem("formulario-registro");
form.addEventListener('submit', function (ev) {

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/bbdd/registro.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            document.getElementById("resultado").innerHTML = oReq.responseText;
        } else {
            document.getElementById("resultado").innerHTML = oReq.responseText;
        }
    };

    //console.log(nick+"  "+nombre+" "+pass+" "+passtxt+ " "+email+" ")
    oReq.send(new FormData(document.forms.namedItem("formulario-registro")));
    ev.preventDefault();

}, false);



/*******  AJAX Formulario Login *****/
var form2 = document.forms.namedItem("formulario-login");
form2.addEventListener('submit', function (ev) {

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "php/bbdd/login.php", true);

    oReq.onload = function (oEvent) {
        if (oReq.status == 200) {
            if (oReq.responseText == "true") {
                explorador();
            } else {
                document.getElementById("resultado").innerHTML = oReq.responseText;
            }
        } else {
            document.getElementById("resultado").innerHTML = oReq.responseText;
        }
    };

    oReq.send(new FormData(document.forms.namedItem("formulario-login")));
    ev.preventDefault();

}, false);


/** FUNCION PASAR AL EXPLORADOR**/

function explorador(){
    setTimeout("location.href='index.php'", 3000);
    document.getElementById("formularios").style = "opacity: 0; transition: 2s linear;"
}