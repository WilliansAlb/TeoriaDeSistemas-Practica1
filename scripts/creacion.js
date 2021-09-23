window.onload = function () {
    $("#formEstudiante").bind("submit", function () {
        var usuario = document.getElementById("usuario").value;
        var nombres = document.getElementById("nombres").value;
        var apellidos = document.getElementById("apellidos").value;
        var interareas = document.getElementById("interareas").value;
        var rep = document.getElementById("rep").value;
        var contra = document.getElementById("contra").value;
        var tipo = document.getElementById("tipo").value;
        var profesion = document.getElementById("profesion").value;
        if (rep != contra) {
            $("#server_respuesta").text("Contraseñas no coinciden!");
            $("#div_respuesta").fadeIn();
            $("#div_respuesta").fadeOut(4000);
        } else {
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: { usuario: usuario, nombres: nombres, apellidos: apellidos,intereses:interareas, contra: contra, tipo: tipo, profesion:profesion},
                beforeSend: function () {
                    console.log("Enviar datos");
                },
                complete: function (data) {
                    console.log("Completados datos");
                },
                success: function (data) {
                    $("#server_respuesta").html(data);
                    $("#div_respuesta").fadeIn();
                },
                error: function (data) {
                    alert("Problemas al tratar de enviar el formulario");
                }
            });
        }
        return false;
    });
}

function login(){
    var usuario = document.getElementById("usuario").value;
    var contra = document.getElementById("contra").value;
    if (usuario!='' && contra!=''){
        $.ajax({
            type: 'POST',
            url: 'http://localhost/Teoria/servers/login.php',
            data: { usuario: usuario, contra: contra},
            beforeSend: function () {
                console.log("Enviar datos");
            },
            complete: function (data) {
                console.log("Completados datos");
            },
            success: function (data) {
                if (data=='REDIRECCION'){
                    window.location = "http://localhost/Teoria/inicio.php";
                }else{
                    $("#server_respuesta").html(data);
                    $("#div_respuesta").fadeIn();
                }
            },
            error: function (data) {
                alert("Problemas al tratar de enviar el formulario");
            }
        });
    }
}