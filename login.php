<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="estilos/cuaderno.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@200;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div id="banner"></div>
    <div>
        <div id="paper" style="margin: 2em; width:50%;display:inline-block;">
            <div id="pattern">
                <div id="content">
                    <h1>Login</h1>
                    <div id="formulario">
                        <div id="estudiante" class="formulario" style="margin-top: 0.6em;">
                            <label for="usuario">Usuario:</label>
                            <input type="text" id="usuario" name="usuario" required>
                            <label for="contra">Contraseña:</label>
                            <input type="password" id="contra" name="contra" required>
                        </div>
                        <div style="padding-top: 0.5em;">
                            <button style="font-size: 1em;" onclick="login()">ENTRAR</button>
                            <a href="http://localhost/Teoria/creacion.php">CREA UNA CUENTA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="float: right;background-color:white; padding:2em; margin:4em; border-radius:1em;" id="div_respuesta">
            <span id="server_respuesta" style="font-size: 20px;">NUMERO 1 EN EDUCACION ONLINE</span>
        </div>
    </div>
    <script src="scripts/creacion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>