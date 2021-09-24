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
    $sql = "UPDATE Curso SET nombre = ?, nivel = ?, descripcion = ?, areas = ? WHERE codigo = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sissi", $_POST["nombre"],$_POST["nivel"],$_POST["descripcion"],$_POST["areas"],$_POST["codigo"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            $respuesta = "<span>Tu curso ha sido editado exitosamente</span><a href='http://localhost/Teoria/inicio.php'>IR A LOGIN</a>";
        } else {
            $respuesta = "<span>Ocurrio un error inesperado al crear el usuario</span>";
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
    echo $respuesta;
}