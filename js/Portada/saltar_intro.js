$("#boton-login-registro").click(function () {
    $("#formularios").css({
        opacity: 1
    });
    $("#boton-login-registro").css({
        opacity: 0
    });
    $(".os-phrases h2").css({
        opacity: 0
    });
});

setTimeout(function () {
    $("#formularios").css({
        opacity: 1
    });
    $("#boton-login-registro").css({
        opacity: 0
    });
    $(".os-phrases h2").css({
        opacity: 0
    });
}, 28000);