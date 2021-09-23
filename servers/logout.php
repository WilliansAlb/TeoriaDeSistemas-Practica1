<?php
     session_start(); 
     unset($_SESSION["usuario"]); 
     unset($_SESSION["tipo"]); 
     header("Location: http://localhost/Teoria/login.php");
