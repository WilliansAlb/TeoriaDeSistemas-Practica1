function agregarInteres() {
    var ti = $("#text_interes").val();
    if (ti == '') {
        return;
    }
    var actuales = document.querySelectorAll('.val');
    for (let i = 0; i < actuales.length; i++) {
        if (actuales[i].textContent == ti) {
            return;
        }
    }
    document.getElementById("intereses1").innerHTML += "<span class='inter'><span class='val'>" + ti + "</span><a onclick='eliminar(this)''>X</a></span>";
}

function agregarInteres2() {
    var ti = $("#text_interes2").val();
    if (ti == '') {
        return;
    }
    var actuales = document.querySelectorAll('.val2');
    for (let i = 0; i < actuales.length; i++) {
        if (actuales[i].textContent == ti) {
            return;
        }
    }
    document.getElementById("intereses2").innerHTML += "<span class='inter'><span class='val2'>" + ti + "</span><a onclick='eliminar(this)''>X</a></span>";
}

function eliminar(a) {
    var spa = a.parentNode;
    var pa = spa.parentNode;
    pa.removeChild(spa);
}

function mostrando(span, op2, esEstudiante) {
    var op = document.querySelectorAll('.opciones');
    if (op.length == 1) {
        var spans = op[0].querySelectorAll('span');
        for (let i = 0; i < spans.length; i++) {
            if (i != op2)
                spans[i].classList.remove('seleccionado');
        }
        span.classList.add("seleccionado");
    }
    if (esEstudiante) {
        if (op2 == 0) {
            $("#cursos").show(1000);
            $("#explorar").hide();
            $("#editar").hide();
        } else if (op2 == 1) {
            $("#cursos").hide();
            $("#explorar").show(1000);
            $("#editar").hide();
        } else {
            $("#cursos").hide();
            $("#explorar").hide();
            $("#editar").show(1000);
        }
    } else {
        if (op2 == 0) {
            $("#cursos_creados").show(1000);
            $("#crear_curso").hide();
            $("#editar").hide();
        } else if (op2 == 1) {
            $("#cursos_creados").hide();
            $("#crear_curso").show(1000);
            $("#editar").hide();
        } else {
            $("#cursos_creados").hide();
            $("#crear_curso").hide();
            $("#editar").show(1000);
        }
    }
}

function crear() {
    var nom = document.getElementById("nombre_curso").value;
    var nivel = document.getElementById("nivel").value;
    var actuales = document.querySelectorAll('.val2');
    var descripcion = document.getElementById("descripcion").value;
    var areas = "";
    var fecha = new Date();
    var dd = String(fecha.getDate()).padStart(2, '0');
    var mm = String(fecha.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = fecha.getFullYear();
    
    fecha =yyyy+'/'+mm + '/' + dd;
    if (nom == "") {
        alert("Ingresa el nombre del curso");
        return;
    }
    if (actuales.length > 0) {
        for (let i = 0; i < actuales.length; i++) {
            if (i != actuales.length - 1) {
                areas += actuales[i].textContent + "-";
            } else {
                areas += actuales[i].textContent;
            }
        } 
        $.ajax({
            type: 'POST',
            url: 'http://localhost/Teoria/servers/crearCurso.php',
            data: { nombre: nom, nivel: nivel, areas:areas, descripcion:descripcion, fecha: fecha},
            beforeSend: function () {
                console.log("Enviar datos");
            },
            complete: function (data) {
                console.log("Completados datos");
            },
            success: function (data) {
                if (data == 'REDIRECCION') {
                    window.location = "http://localhost/Teoria/inicio.php";
                } else {
                    $("#server_respuesta").html(data);
                    $("#div_respuesta").fadeIn();
                }
            },
            error: function (data) {
                alert("Problemas al tratar de enviar el formulario");
            }
        });
    } else {
        alert("colocale areas de interes");
    }
}