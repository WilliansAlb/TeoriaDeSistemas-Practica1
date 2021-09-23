<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$usuario = $password = $confirm_password = "";
$usuario_err = $password_err = $confirm_password_err = "";
$respuesta = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["tipo"] == "estudiante" || $_POST["tipo"] == "profesor") {
        $sql = "SELECT usuario FROM Usuarios WHERE usuario = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $parametro_usuario);

            // Set parameters
            $parametro_usuario = trim($_POST["usuario"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $respuesta = "<span style='color:red;'>El usuario que ingresaste ya existe</span>";
                } else {
                    $usuario = trim($_POST["usuario"]);
                }
            } else {
                $respuesta = "<span style='color:red;'>Ocurrio un error inesperado</span>";
            }

            // Close statement
            $stmt->close();
        }

        $password = trim($_POST["contra"]);

        // Check input errors before inserting in database
        if (empty($respuesta)) {

            // Prepare an insert statement
            $sql = "INSERT INTO Usuarios (usuario, nombres, apellidos, intereses, password,tipo,profesion) VALUES (?, ?, ?, ?, ?, ?,?)";

            if ($stmt = $mysqli->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sssssss", $usuario, $_POST["nombres"], $_POST["apellidos"], $_POST["intereses"], $password, $_POST["tipo"], $_POST["profesion"]);
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to login page
                    $respuesta = "<span>Tu usuario ha sido creado exitosamente</span><a href='http://localhost/Teoria/login.php'>IR A LOGIN</a>";
                } else {
                    $respuesta = "<span>Ocurrio un error inesperado al crear el usuario</span>";
                }

                // Close statement
                $stmt->close();
            }
        }
    } else {
        $respuesta = "<span style='color:red;'>Ocurrio un error inesperado</span>";
    }
    // Close connection
    $mysqli->close();
    echo $respuesta;
}
