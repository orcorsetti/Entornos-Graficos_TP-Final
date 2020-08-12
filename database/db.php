<?php
    include('db_config.php');
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    $namespace = "http://localhost/Entornos-Graficos_TP-Final/";

    $conn = mysqli_connect($host, $user, $password, $db);
    if($conn -> connect_errno){
        die('Error en al conexión a la Base de datos'.$conn->connect_error);
    }

?>