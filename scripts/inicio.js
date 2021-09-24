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

function agregarInteres3(codigo) {
    var ti = $("#text_interes3"+codigo).val();
    if (ti == '') {
        return;
    }
    var actuales = document.querySelectorAll('.val3'+codigo);
    for (let i = 0; i < actuales.length; i++) {
        if (actuales[i].textContent == ti) {
            return;
        }
    }
    $("#text_interes3"+codigo).val("")
    document.getElementById("intereses3"+codigo).innerHTML += "<span class='inter'><span class='val3"+codigo+"'>" + ti + "</span><a onclick='eliminar(this)''>X</a></span>";
}

function editando_curso(codigo) {
    var nom = document.getElementById("nombre_c"+codigo).value;
    var nivel = document.getElementById("nivel_c"+codigo).value;
    var actuales = document.querySelectorAll('.val3'+codigo);
    var descripcion = document.getElementById("descripcion_c"+codigo).value;
    var areas = "";
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
            url: 'http://localhost/Teoria/servers/editarCurso.php',
            data: { nombre: nom, nivel: nivel, areas: areas, descripcion: descripcion, codigo:codigo},
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

    fecha = yyyy + '/' + mm + '/' + dd;
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
            data: { nombre: nom, nivel: nivel, areas: areas, descripcion: descripcion, fecha: fecha },
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

function buscando(input) {
    var els = document.querySelectorAll(".curso_texto");
    var ets = document.querySelectorAll(".etiqueta");
    for (let i = 0; i < els.length; i++) {
        if (els[i].textContent.toLowerCase().includes(input.value.toLowerCase())) {
            var p1 = els[i].parentNode.parentNode;
            p1.style.display = "";
        } else {
            var p1 = els[i].parentNode.parentNode;
            p1.style.display = "none";
        }
    }
    console.log("llega acá " + ets.length);
    for (let e = 0; e < ets.length; e++) {
        if (ets[e].textContent.toLowerCase().includes(input.value.toLowerCase())) {
            var p1 = ets[e].parentNode.parentNode.parentNode.parentNode.parentNode;
            p1.style.display = "";
        }
    }
}
var code = -1;
function asignar(codigo, spa) {
    console.log(code);
    code = codigo;
    var curso = spa.parentNode.parentNode.textContent;
    var curso = curso.replace(" ASIGNAR", "");
    document.getElementById("confirmacion_asignacion").style.display = "";
    $("#asignar_curso").text(curso);
    $("#oculto").fadeIn();
}

var code2 = -1;
function desasignar(codigo, spa) {
    code2 = codigo;
    var curso = spa.parentNode.parentNode.textContent;
    var curso = curso.replace(" DESASIGNAR", "");
    document.getElementById("confirmacion_desasignacion").style.display = "";
    $("#desasignar_curso").text(curso);
    $("#oculto").fadeIn();
}

function asignar_curso() {
    var fecha = obtener_fecha();
    var codigo = code;
    if (code == -1) {
        return;
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/Teoria/servers/asignacion.php',
        data: { curso: codigo, fecha: fecha, tipo: "asignar" },
        beforeSend: function () {
            console.log("Enviar datos");
        },
        complete: function (data) {
            console.log("Completados datos");
        },
        success: function (data) {
            $("#confirmacion_asignacion").hide();
            $("#confirmacion_desasignacion").hide();
            document.getElementById("confirmacion_respuesta").style.display = "";
            $("#confirmacion_respuesta").html(data);
            $("#oculto").fadeIn();
        },
        error: function (data) {
            alert("Problemas al tratar de enviar el formulario");
        }
    });
}

function desasignar_curso() {
    var codigo = code2;
    if (code2 == -1) {
        return;
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/Teoria/servers/asignacion.php',
        data: { codigo: codigo, tipo: "desasignar" },
        beforeSend: function () {
            console.log("Enviar datos");
        },
        complete: function (data) {
            console.log("Completados datos");
        },
        success: function (data) {
            $("#confirmacion_asignacion").hide();
            $("#confirmacion_desasignacion").hide();
            document.getElementById("confirmacion_respuesta").style.display = "";
            $("#confirmacion_respuesta").html(data);
            $("#oculto").fadeIn();
        },
        error: function (data) {
            alert("Problemas al tratar de enviar el formulario");
        }
    });
}

function obtener_fecha() {
    var fecha = new Date();
    var dd = String(fecha.getDate()).padStart(2, '0');
    var mm = String(fecha.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = fecha.getFullYear();
    return yyyy + '/' + mm + '/' + dd;
}

function editar_datos(tipo) {
    var nombres = document.getElementById("nombres").value;
    var apellidos = document.getElementById("apellidos").value;
    var profesion = document.getElementById("profesion").value;
    var areas = document.querySelectorAll('.val');
    var area = "";
    if (areas.length > 1) {
        var elementos = [];
        for (let i = 0; i < areas.length; i++) {
            if (areas[i].textContent != "*")
                elementos.push(areas[i].textContent);
        }
        for (let i = 0; i < elementos.length; i++) {
            if (i == elementos.length - 1)
                area += elementos[i];
            else
                area += elementos[i] + "-";
        }
    } else {
        if (areas.length == 0) {
            if (tipo == "estudiante") {
                area = "*";
            } else {
                alert("Ingresa un area");
                return;
            }
        } else {
            console.log(tipo);
            if (tipo == "estudiante") {
                area = areas[0].textContent;
            } else {
                if (areas[0].textContent == '*') {
                    alert("No puedes estar en todas las areas");
                    return;
                } else {
                    area = areas[0].textContent;
                }
            }
        }
    }
    console.log("ingresando");
    $.ajax({
        type: 'POST',
        url: 'http://localhost/Teoria/servers/editarUsuario.php',
        data: { nombres: nombres, apellidos: apellidos, profesion: profesion, intereses: area },
        beforeSend: function () {
            console.log("Enviar datos");
        },
        complete: function (data) {
            console.log("Completados datos");
        },
        success: function (data) {
            $("#confirmacion_asignacion").hide();
            $("#confirmacion_desasignacion").hide();
            document.getElementById("confirmacion_respuesta").style.display = "";
            $("#confirmacion_respuesta").html(data);
            $("#oculto").fadeIn();
        },
        error: function (data) {
            alert("Problemas al tratar de enviar el formulario");
        }
    });
}