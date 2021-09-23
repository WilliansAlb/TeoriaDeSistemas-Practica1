<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>
    <link rel="stylesheet" href="estilos/estilos.css">
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
        </div>
    </nav>
    <div id="banner"></div>
    <div id="paper" style="margin: 2em; width:50%;display:inline-block;">
        <div id="pattern">
            <div id="content">
                <h1>Listado de profesores</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>DPI</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>nn</td>
                            <td>mm</td>
                            <td>11</td>
                            <td>yy</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div style="float: right;background-color:white; padding:2em; border-radius:1em; margin:3em; font-size:20px;" id="div_respuesta">
        <span id="server_respuesta">Actualmente estás viendo el listado de</span>
        <select name="listar" id="listar">
            <option value="profesores">PROFESORES</option>
            <option value="estudiantes">ESTUDIANTES</option>
            <option value="clase">CLASES</option>
        </select>
    </div>
</body>

</html>