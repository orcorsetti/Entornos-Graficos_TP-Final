<?php
include('../database/db.php');

if($_SESSION['user-type']=="admin"){

    if(isset($_GET['deletedID'])){
        $dni = $_GET['deletedID'];
        $query = "DELETE FROM administradores WHERE dni = '$dni'";
        $conn -> query($query);
        if($conn -> errno){
            $_SESSION['badRequestError'] = $conn->error;
        } else {
            $_SESSION['message'] = "Usuario Eliminado Correctamente";
            $_SESSION['message-type'] = "success";
        }
    }

    if(isset($_POST['create-admin'])){
        if(isset($_POST['dni']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])){
            $dni = $_POST['dni'];
            $nombre = $_POST['name'];
            $apellido = $_POST['lastname'];
            $email = $_POST['email'];
            $contraseña = 'abc123';

            $query = "INSERT INTO administradores(dni, nombre, apellido, email, contraseña) VALUES ('$dni', '$nombre', '$apellido', '$email', '$contraseña')";
            $conn -> query($query);

            if($conn-> errno){
                $_SESSION['badRequestError'] = $conn->error; 
            } else {
                $_SESSION['message'] = "Administrador creado correctamente";
                $_SESSION['message-type'] = "success";
            }
        } else {
            $_SESSION['badRequestError'] = "Faltan campos requeridos";
        }
    }

    if(isset($_POST['edit-admin'])){
        if(isset($_POST['dni']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])){
            $dni = $_POST['dni'];
            $nombre = $_POST['name'];
            $apellido = $_POST['lastname'];
            $email = $_POST['email'];

            $query = "UPDATE administradores SET dni = '$dni' , nombre = '$nombre', apellido = '$apellido', email = '$email' WHERE dni='$dni'";
            $conn -> query($query);
            if($conn->errno){
                $_SESSION['badRequestError'] = $conn->error;
            } else {
                $_SESSION['message'] = "Administrador actualizado correctamente";
                $_SESSION['message-type'] = "success";
            }
        } else {
            $_SESSION['badRequestError'] = "Faltan campos requeridos";
        }
    }
}else{
    $_SESSION['badRequestError'] = "No tiene los permisos necesarios para realizar esta acción";
}
header('Location: '.$namespace.'views/admins/CRUD/administrator.php');
?>