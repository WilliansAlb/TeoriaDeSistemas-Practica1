<?php
// Include config file
require_once "servers/config.php";
session_start();
$nombres = $apellidos = $profesion = $intereses = "";
$data = [];
$cursos = [];
if (isset($_SESSION['usuario'])) {
    $sql = "SELECT nombres,apellidos,profesion,intereses FROM Usuarios WHERE usuario = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $_SESSION["usuario"]);
        if ($stmt->execute()) {
            // store result
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($nombres, $apellidos, $profesion, $intereses);
                $stmt->fetch();
            }
        }
        // Close statement
        $stmt->close();
    }
    if ($_SESSION["tipo"] == "estudiante") {
        $sql = "SELECT *, a.fecha AS afecha, a.codigo AS acodigo FROM Asignaciones a, Curso c WHERE a.estudiante = ? AND a.curso = c.codigo ";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $_SESSION["usuario"]);
            if ($stmt->execute()) {
                // store result
                $result = $stmt->get_result(); // get the mysqli result
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            // Close statement
            $stmt->close();
        }
    } else {
        $sql = "SELECT * FROM Curso WHERE profesor = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $_SESSION["usuario"]);
            if ($stmt->execute()) {
                // store result
                $result = $stmt->get_result(); // get the mysqli result
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            // Close statement
            $stmt->close();
        }
    }

    $sql = "SELECT codigo,nombre,nivel,descripcion,areas,fecha,nombres,profesor,apellidos,intereses,profesion FROM Curso c, Usuarios u WHERE c.profesor = u.usuario";
    if ($stmt = $mysqli->prepare($sql)) {
        if ($stmt->execute()) {
            // store result
            $result = $stmt->get_result(); // get the mysqli result
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
} else {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/estilos2.css">
    <link rel="stylesheet" href="estilos/cuaderno.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="imagenes/png/011-school.png" />
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@200;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <div id="navbar">
            <a href="inicio.php">
                <img src="imagenes/png/011-school.png" alt="escuela" width="40px">ESCUELA
            </a>
            <span></span>
            <span></span>
            <span></span>
            <div style="margin: auto;">
                <a href="servers/logout.php">Salir</a>
            </div>
        </div>
    </nav>
    <div id="banner"></div>
    <div class="contenedor2">
        <center>
            <img src="imagenes/png/002-atom.png" alt="atom"">
        </center>
        <div class=" datos">
            <h1><span><?php echo $nombres; ?></span> <span><?php echo $apellidos; ?></span></h1>
            <span><?php echo $_SESSION["usuario"]; ?></span>
            <br>
            <span style="color: skyblue; font-size:1em;">Cuenta de <?php echo $_SESSION["tipo"]; ?></span>
    </div>
    </div>
    <div class="cuerpo">
        <div class="opciones" style="row-gap: 5px;">
            <?php if ($_SESSION['tipo'] == 'estudiante') : ?>
                <span class="seleccionado" onclick="mostrando(this,0,true)">CURSOS ASIGNADOS</span>
                <span onclick="mostrando(this,1,true)">EXPLORA</span>
                <span onclick="mostrando(this,2,true)">PERFIL</span>
            <?php else : ?>
                <span class="seleccionado" onclick="mostrando(this,0,false)">CURSOS CREADOS</span>
                <span onclick="mostrando(this,1,false)">CREA CURSO</span>
                <span onclick="mostrando(this,2,false)">PERFIL</span>
            <?php endif ?>
        </div>
        <div class="contenidos">
            <?php if ($_SESSION['tipo'] == 'estudiante') : ?>
                <div id="cursos">
                    <?php if ($data) : ?>
                        <?php foreach ($data as $row) : ?>
                            <div class="componente1 cuaderno_lineas">
                                <h1><?php echo $row["codigo"] ?> - <?php echo $row["nombre"] ?> <span><a class="desasignate" onclick="desasignar(<?php echo $row['acodigo']; ?>,this)">DESASIGNAR</a></span></h1>
                                <span><img style="width: 1.5rem" src="imagenes/png/046-library.png" alt="nivel">
                                    <?php
                                    if ($row["nivel"] == 0) :
                                        echo "Principiante";
                                    elseif ($row["nivel"] == 1) :
                                        echo "Intermedio";
                                    else :
                                        echo "Avanzado";
                                    endif;
                                    ?>
                                </span>
                                <span><img style="width: 1.5rem" src="imagenes/png/019-teacher.png" alt="nivel">
                                    <?php
                                    echo $row["profesor"]; ?>
                                </span>
                                <hr>
                                <br>
                                <span><?php echo $row["descripcion"] ?></span>
                                <br>
                                <br>
                                <hr>
                                <span>Asignado el <?php echo $row["afecha"] ?> || Creado el <?php echo $row["fecha"] ?></span>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="componente1">
                            <span>Aún no te has asignado a ningún curso</span>
                        </div>
                    <?php endif ?>
                </div>
                <div id="explorar" style="display: none;">
                    <?php if ($cursos) : ?>
                        <div class="componente1 cuaderno_lineas">
                            <label for="buscar">BUSCAR CURSO: </label>
                            <input type="text" id="buscar" onchange="buscando(this)" style="    width: -webkit-fill-available;">
                        </div>
                        <?php foreach ($cursos as $row) : ?>
                            <div class="componente3 cuaderno_lineas">
                                <div style="display: flex;flex-direction: column;">
                                    <h1 class="curso_texto"><?php echo $row["codigo"] . " - " . $row["nombre"]; ?> <span><a class="asignate" onclick="asignar(<?php echo $row['codigo']; ?>,this)">ASIGNAR<img src="imagenes/png/007-notebook.png" alt="asignar"></a></span></h1>
                                    <span><img style="width: 1.5rem" src="imagenes/png/046-library.png" alt="nivel">
                                        <?php
                                        if ($row["nivel"] == 0) :
                                            echo "Principiante";
                                        elseif ($row["nivel"] == 1) :
                                            echo "Intermedio";
                                        else :
                                            echo "Avanzado";
                                        endif;
                                        ?>
                                    </span>
                                    <br>
                                    <span><?php echo $row["descripcion"] ?></span>
                                    <br>
                                    <div>
                                        <span>Etiquetas:
                                            <?php
                                            $array1 = explode("-", $row["areas"]);
                                            foreach ($array1 as $el) :
                                                echo "<span class='inter'><span class='etiqueta'>" . $el . "</span></span>";
                                            endforeach
                                            ?>
                                        </span>
                                    </div>
                                    <hr>
                                    <span>Publicado el <?php echo $row["fecha"] ?></span>
                                </div>
                                <div class="datos_profesor">
                                    <h3>Profesor</h3>
                                    <img src="imagenes/png/019-teacher.png" alt="maestro" width="30%">
                                    <span><span><?php echo $row["nombres"] ?></span> <span><?php echo $row["apellidos"] ?></span></span>
                                    <span style="font-size: 0.8em;"><?php echo $row["profesor"] ?></span>
                                    <hr>
                                    <span><?php echo $row["profesion"] ?></span>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="componente1">
                            <span>Aún no se han creado cursos</span>
                        </div>
                    <?php endif ?>
                </div>
                <div id="editar" class="edicion cuaderno_lineas" style="display: none;">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" required value="<?php echo $nombres; ?>">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required value="<?php echo $apellidos; ?>">
                    <label for="intereses">Intereses:</label>
                    <div>
                        <input type="text" id="text_interes">
                        <button onclick="agregarInteres()">AGREGAR</button>
                    </div>
                    <span id="intereses1">
                        <?php
                        $array1 = explode("-", $intereses);
                        foreach ($array1 as $el) :
                            echo "<span class='inter'><span class='val'>" . $el . "</span><a onclick='eliminar(this)''>X</a></span>";
                        endforeach
                        ?>
                    </span>
                    <label for="profesion">Profesion:</label>
                    <input type="text" id="profesion" name="profesion" required value="<?php echo $profesion; ?>">
                    <button onclick="editar_datos('<?php echo $_SESSION['tipo']; ?>')">EDITAR</button>
                </div>
            <?php else : ?>
                <div id="cursos_creados">
                    <?php if ($data) : ?>
                        <?php foreach ($data as $row) : ?>
                            <div class="componente1" style="display: flex;flex-direction:column;row-gap:0.2em;">
                                <h1><?php echo $row["nombre"]; ?></h1><button onclick="this.parentNode.style.display='none'; document.getElementById('editando_curso').style.display = 'flex';">EDITAR</button>
                                <span><img style="width: 1.5rem" src="imagenes/png/046-library.png" alt="nivel">
                                    <?php
                                    if ($row["nivel"] == 0) :
                                        echo "Principiante";
                                    elseif ($row["nivel"] == 1) :
                                        echo "Intermedio";
                                    else :
                                        echo "Avanzado";
                                    endif;
                                    ?>
                                </span>
                                <span><?php echo $row["descripcion"]; ?></span>
                                <hr>
                                <div>
                                    <span>Etiquetas:
                                        <?php
                                        $array1 = explode("-", $row["areas"]);
                                        foreach ($array1 as $el) :
                                            echo "<span class='inter'><span class='etiqueta'>" . $el . "</span></span>";
                                        endforeach
                                        ?>
                                    </span>
                                </div>
                                <span><?php echo $row["fecha"] ?></span>
                            </div>
                            <div class="componente1" style="display: none;flex-direction:column;row-gap:0.2em;" id="editando_curso">
                                <label for="nombre_c1">Nombre:</label>
                                <input type="text" name="nombre_c1" id="nombre_c1" value="<?php echo $row['nombre']; ?>">
                                <label for="nivel_c1">Nivel:</label>
                                <select name="nivel_c1" id="nivel_c1">
                                    <option value="0" <?php if ($row["nivel"] == 0) :
                                                            echo "selected";
                                                        endif; ?>>Principiante</option>
                                    <option value="1" <?php if ($row["nivel"] == 1) :
                                                            echo "selected";
                                                        endif; ?>>Intermedio</option>
                                    <option value="2" <?php if ($row["nivel"] == 2) :
                                                            echo "selected";
                                                        endif; ?>>Avanzado</option>
                                </select>
                                <label for="descripcion_c1">Descripcion:</label>
                                <textarea name="descripcion_c1" id="descripcion_c1" cols="30" rows="10"><?php echo $row["descripcion"]; ?></textarea>
                                <label for="text_interes3">Etiquetas: </label>
                                <div>
                                    <input type="text" id="text_interes3">
                                    <button onclick="agregarInteres3()">AGREGAR</button>
                                </div>
                                <span id="intereses3">
                                    <?php
                                    $array1 = explode("-", $row["areas"]);
                                    foreach ($array1 as $el) :
                                        echo "<span class='inter'><span class='val3'>" . $el . "</span><a onclick='eliminar(this)''>X</a></span>";
                                    endforeach
                                    ?>
                                </span>
                                <button onclick="editando_curso(<?php echo $row['codigo'];?>)">EDITAR</button>
                                <a href="inicio.php">CANCELAR</a>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="componente1">
                            <span>Aún no has creado cursos</span>
                        </div>
                    <?php endif ?>
                </div>
                <div id="crear_curso" class="edicion" style="display: none;">
                    <label for="nombre_curso">Nombre del curso:</label>
                    <input type="text" id="nombre_curso" name="nombre_curso" required>
                    <label for="nivel">Nivel:</label>
                    <select name="nivel" id="nivel">
                        <option value="0">Principiante</option>
                        <option value="1">Intermedio</option>
                        <option value="2">Avanzado</option>
                    </select>
                    <label for="descripcion">Descripcion:</label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
                    <label for="areas">Areas:</label>
                    <div>
                        <input type="text" id="text_interes2" name="areas">
                        <button onclick="agregarInteres2()">AGREGAR</button>
                    </div>
                    <span id="intereses2"></span>
                    <button style="margin-top:1em;" onclick="crear()">CREAR</button>
                </div>
                <div id="editar" class="edicion" style="display: none;">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" required value="<?php echo $nombres; ?>">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required value="<?php echo $apellidos; ?>">
                    <label for="intereses">Areas que manejas:</label>
                    <div>
                        <input type="text" id="text_interes">
                        <button onclick="agregarInteres()">AGREGAR</button>
                    </div>
                    <span id="intereses1">
                        <?php
                        $array1 = explode("-", $intereses);
                        foreach ($array1 as $el) :
                            echo "<span class='inter'><span class='val'>" . $el . "</span><a onclick='eliminar(this)''>X</a></span>";
                        endforeach
                        ?>
                    </span>
                    <label for="profesion">Profesion:</label>
                    <input type="text" id="profesion" name="profesion" required value="<?php echo $profesion; ?>">
                    <button style="margin-top:1em;" onclick="editar_datos('<?php echo $_SESSION['tipo']; ?>')">EDITAR</button>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div style="/* float: right; */top: 40%;left: 38%;background-color: #bda8a8;padding: 2em;margin: 4em;border-radius: 1em;z-index: 10;position: fixed;display:none;" id="div_respuesta">
        <span id="server_respuesta">Area de creación de entidades</span>
    </div>
    <div id="oculto" class="oculto" style="display: none;">
        <div id="confirmacion_asignacion" style="display:none;">
            <span>¿Estás seguro de asignarte este curso?</span>
            <h1 id="asignar_curso"></h1>
            <button onclick="asignar_curso()">Sí</button><button onclick="this.parentNode.style.display='none';this.parentNode.parentNode.style.display='none';code=-1;">No</button>
        </div>
        <div id="confirmacion_desasignacion" style="display:none;background-color:red;">
            <span>¿Estás seguro de desasignarte este curso?</span>
            <h1 id="desasignar_curso"></h1>
            <button onclick="desasignar_curso()">Sí</button><button onclick="this.parentNode.style.display='none';this.parentNode.parentNode.style.display='none';code2=-1;">No</button>
        </div>
        <div id="confirmacion_respuesta" style="display: none;"></div>
    </div>
    <script src="scripts/inicio.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>