<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacion</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/cuaderno.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="imagenes/png/011-school.png" />
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@200;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div id="banner"></div>
    <div style="margin: 2em;">
        <div id="paper" style="margin: 2em; width:50%;display:inline-block;">
            <div id="pattern">
                <div id="content">
                    <h1>Ficha de registro</h1>
                    <div id="formulario">
                        <div class="formulario" style="margin-top: 0.5em; margin-bottom: 0.4em;">
                            <label for="tipo">Tipo de cuenta</label>
                            <select name="tipo" id="tipo">
                                <option value="estudiante">ESTUDIANTE</option>
                                <option value="profesor">PROFESOR</option>
                            </select>
                        </div>
                        <form action="servers/crear.php" method="post" id="formEstudiante">
                            <div id="estudiante" class="formulario">
                                <input type="text" name="opcion" style="display:none;" value="estudiante" />
                                <label for="nombres">Nombres:</label>
                                <input type="text" id="nombres" name="nombres" required>
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" required>
                                <label for="profesion">Profesion:</label>
                                <input type="text" id="profesion" name="profesion" required>
                                <label for="interareas">Area principal:</label>
                                <input type="text" id="interareas" name="interareas" value="*" required>
                                <label for="usuario">Crea un usuario:</label>
                                <input type="text" id="usuario" name="usuario" required>
                                <label for="contra">Crea una contraseña:</label>
                                <input type="password" id="contra" name="contra" required>
                                <label for="rep">Repite la contraseña:</label>
                                <input type="password" id="rep" name="rep" required>
                                <button style="font-size: 1em;float:right;">CREAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div style="float: right;background-color:white; padding:2em; margin:4em; border-radius:1em; display:none;" id="div_respuesta">
            <span id="server_respuesta">Area de creación de entidades</span>
        </div>
    </div>
    <script src="scripts/creacion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>