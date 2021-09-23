<?php
// Include config file
require_once "config.php";
session_start();

// Define variables and initialize with empty values
$usuario = $tipo = $password = $confirm_password = "";
$usuario_err = $password_err = $confirm_password_err = "";
$respuesta = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT usuario,tipo FROM Usuarios WHERE usuario = ? AND password = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ss", $_POST["usuario"], $_POST["contra"]);
        if ($stmt->execute()) {
            // store result
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($usuario,$tipo);
                $stmt->fetch();
                $_SESSION['usuario'] = $usuario;
                $_SESSION['tipo'] = $tipo;
                $respuesta = "REDIRECCION";
            } else {
                $respuesta = "<span style='color:red;'>Datos incorrectos!</span>";
            }
        } else {
            $respuesta = "<span style='color:red;'>Ocurrio un error inesperado</span>";
        }

        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
    echo $respuesta;
}
?>
