<?php
// Include config file
require_once "config.php";
session_start();
// Define variables and initialize with empty values
$usuario = $password = $confirm_password = "";
$usuario_err = $password_err = $confirm_password_err = "";
$respuesta = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE Usuarios SET nombres = ?, apellidos = ?, intereses = ?, profesion = ? WHERE usuario = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssss", $_POST["nombres"], $_POST["apellidos"], $_POST["intereses"], $_POST["profesion"],$_SESSION["usuario"]);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            $respuesta = "<span>Has editado correctamente tu usuario</span><hr><a href='http://localhost/Teoria/inicio.php'>ACEPTAR</a>";
        } else {
            $respuesta = "<span>Ocurrio un error inesperado al crear el usuario</span><hr><a href='http://localhost/Teoria/inicio.php'>ACEPTAR</a>";
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
    echo $respuesta;
}