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
        $sql = "SELECT * FROM Asignaciones WHERE usuario = ?";
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

    $sql = "SELECT * FROM Curso";
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
    <title>Listado</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/estilos2.css">
    <link rel="stylesheet" href="estilos/cuaderno.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@200;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <div id="navbar">
            <a href="registro.php">
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
                <span class="seleccionado" onclick="mostrando(this,0,false)">TUS CURSOS</span>
                <span onclick="mostrando(this,1,false)">CREA</span>
                <span onclick="mostrando(this,2,false)">PERFIL</span>
            <?php endif ?>
        </div>
        <div class="contenidos">
            <?php if ($_SESSION['tipo'] == 'estudiante') : ?>
                <div id="cursos">
                    <?php if ($data) : ?>
                        <ul>
                            <?php foreach ($data as $row) : ?>
                                <div class="componente1">
                                    <h1><?php echo $row["nombre"] ?></h1>
                                    <span><?php echo $row["descripcion"] ?></span>
                                </div>
                            <?php endforeach ?>
                        </ul>
                    <?php else : ?>
                        <div class="componente1">
                            <span>Aún no te has asignado a ningún curso</span>
                        </div>
                    <?php endif ?>
                </div>
                <div id="explorar" style="display: none;">
                    <?php if ($cursos) : ?>
                        <ul>
                            <?php foreach ($cursos as $row) : ?>
                                <div class="componente1">
                                    <h1><?php echo $row["nombre"] ?></h1>
                                    <span><?php echo $row["descripcion"] ?></span>
                                </div>
                            <?php endforeach ?>
                        </ul>
                    <?php else : ?>
                        <div class="componente1">
                            <label for="buscar">BUSCAR CURSO: </label>
                            <input type="text" id="buscar" style="    width: -webkit-fill-available;">
                        </div>

                        <div class="componente1">
                            <span>Aún no se han creado cursos</span>
                        </div>
                    <?php endif ?>
                </div>
                <div id="editar" class="edicion" style="display: none;">
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
                    <button>EDITAR</button>
                </div>
            <?php else : ?>
                <div id="cursos_creados">
                    <?php if ($data) : ?>
                        <ul>
                            <?php foreach ($data as $row) : ?>
                                <div class="componente1">
                                    <h1><?php echo $row["nombre"] ?></h1>
                                    <span><?php echo $row["descripcion"] ?></span>
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
                            <?php endforeach ?>
                        </ul>
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
                    <button style="margin-top:1em;">EDITAR</button>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div style="/* float: right; */top: 40%;left: 38%;background-color: #bda8a8;padding: 2em;margin: 4em;border-radius: 1em;z-index: 10;position: fixed;display:none;" id="div_respuesta">
        <span id="server_respuesta">Area de creación de entidades</span>
    </div>
    <script src="scripts/inicio.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>