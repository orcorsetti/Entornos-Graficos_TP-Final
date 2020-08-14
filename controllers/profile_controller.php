<?php

include("../database/db.php");
try{
    if(isset($_POST['changePassword'])){
        if(isset($_POST['old_password']) && isset($_POST['id']) && isset($_POST['new_password']) && isset($_POST['new_password2'])){
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $new_password2 = $_POST['new_password2'];
            $id = $_POST['id'];

            if($_SESSION['user-type']=="admin"){
                $query = "SELECT contraseña FROM administradores WHERE dni='$id' LIMIT 0,1";
            } elseif ($_SESSION['user-type']=="teacher") {
                $query = "SELECT contraseña FROM docentes WHERE dni='$id' LIMIT 0,1";
            }
            if(isset($query)){
                $result = $conn -> query($query) ;
                if ($conn->errno) {
                    throw new Exception("Error al acceder a la Base de Datos");
                }
                $user = $result -> fetch_assoc();
                if($old_password === $user['contraseña']){
                    if($new_password === $new_password2){
                        if($_SESSION['user-type']=="admin"){
                            $query = "UPDATE administradores SET contraseña='$new_password' WHERE dni='$id'";
                        } elseif($_SESSION['user-type'=="teacher"]){
                            $query = "UPDATE docentes SET contraseña='$new_password' WHERE dni='$id'";
                        }
                        $conn->query($query);
                        if($conn->errno){
                            throw new Exception("Error al actualizar la contraseña: ".$conn->error);
                        }
                        $_SESSION["message"] = "Contraseña cambiada exitosamente";
                        $_SESSION["message-type"] = "success";
                    } else{
                        throw new Exception("Las contraseñas no coinciden.");
                    }
                } else {
                    throw new Exception("Su contraseña anterior no es correcta.");
                }
            } else {
                throw new Exception("No los permisos correctos para esta sección.");
            }
        } else {
            throw new Exception("Faltan campos requeridos");
        }
        header('Location: '.$namespace.'profile.php');
    }

    if(isset($_POST['closeSession'])){
        unset($_SESSION['user']);
        unset($_SESSION['user-type']);
        header('Location: '.$namespace);
    }

    if(isset($_POST['editUser'])){
        if(isset($_POST['id']) && $_POST['previous_id'] && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])){
            $id=$_POST['id'];
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $previousId = $_POST['previous_id'];
            checkEmail($email, $previousId, $conn);
            if($id !== $previousId){
                checkId($id, $conn);
            }
            if($_SESSION['user-type']=="admin"){
                $query = "UPDATE administradores SET dni='$id', nombre='$name', apellido='$lastname', email='$email' WHERE dni='$previousId'";
            } elseif ($_SESSION['user-type']=="teacher") {
                $query = "UPDATE docentes SET dni='$id', nombre='$name', apellido='$lastname', email='$email' WHERE dni='$previousId'";
            } elseif ($_SESSION['user-type']=="student") {
                $query = "UPDATE alumnos SET legajo='$id', nombre='$name', apellido='$lastname', email='$email' WHERE legajo='$previousId'";
            }
            if(isset($query)){
                $conn -> query($query);
                if($conn -> errno){
                    throw new Exception("Error al actualizar el perfil.");
                }
                $_SESSION['message'] = "Perfil actualizado correctamente.";
                $_SESSION['message-type'] = "success";
                $_SESSION['user'] = $id;
                header('Location: '.$namespace.'profile.php');
            } else {
                throw new Exception("No tiene permisos para ingresar a esta sección");
            }
        } else {
            throw new Exception("Faltan campos requeridos");
        }
    }
} catch(Exception $ex){
    $_SESSION['error'] = $ex -> getMessage();
    header('Location: '.$namespace.'profile.php');
}

function checkEmail($email, $id, $conn){
    if($_SESSION['user-type']=="admin"){
        $query = "SELECT * FROM administradores WHERE email='$email' AND dni!='$id'";
    } elseif ($_SESSION['user-type']=="teacher") {
        $query = "SELECT * FROM docentes WHERE email='$email' AND dni!='$id'";
    } elseif ($_SESSION['user-type']=="student") {
        $query = "SELECT * FROM alumnos WHERE email='$email' AND legajo!='$id'";
    }
    if($query){
        $result = $conn -> query($query);
        if($result->num_rows > 0){
            throw new Exception("El email ingresado ya se encuentra cargado.");
        }
    }
}

function checkId($id, $conn){
    $userID = "DNI";
    if($_SESSION['user-type']=="admin"){
        $query = "SELECT * FROM administradores WHERE dni='$id'";
    } elseif ($_SESSION['user-type']=="teacher") {
        $query = "SELECT * FROM docentes WHERE dni='$id'";
    } elseif ($_SESSION['user-type']=="student") {
        $query = "SELECT * FROM alumnos WHERE legajo='$id'";
        $userID = "legajo";
    }
    if($query){
        $result = $conn -> query($query);
        if($result->num_rows > 0){
            throw new Exception("El ".$userID." ingresado ya se encuentra cargado.");
        }
    }
}
?>