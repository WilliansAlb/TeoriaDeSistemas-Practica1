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
    if ($_POST["tipo"] == "asignar") {
        $sql = "INSERT INTO Asignaciones (curso, estudiante, fecha) SELECT ?, ?, ? FROM DUAL WHERE NOT EXISTS (SELECT * FROM Asignaciones WHERE curso=? AND estudiante=? LIMIT 1)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("issis", $_POST["curso"], $_SESSION["usuario"], $_POST["fecha"], $_POST["curso"], $_SESSION["usuario"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                $respuesta = "<span>Te has asignado exitosamente al curso</span><hr><a href='http://localhost/Teoria/inicio.php'>ACEPTAR</a>";
            } else {
                $respuesta = "<span>Ocurrio un error inesperado al crear el usuario</span>";
            }
            // Close statement
            $stmt->close();
        }
    } else {
        $sql = "DELETE FROM Asignaciones WHERE codigo = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $_POST["codigo"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                $respuesta = "<span>Te has desasignado exitosamente al curso</span><hr><a href='http://localhost/Teoria/inicio.php'>ACEPTAR</a>";
            } else {
                $respuesta = "<span>Ocurrio un error inesperado al eliminar la asignacion</span>";
            }
            // Close statement
            $stmt->close();
        }
    }
    // Close connection
    $mysqli->close();
    echo $respuesta;
}
