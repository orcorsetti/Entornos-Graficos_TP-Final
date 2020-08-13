<?php
include('../../database/db.php');

if($_SESSION['user-type']=="admin"){

    if(isset($_GET['deletedID'])){
        try{
            $dni = $_GET['deletedID'];
            $query = "DELETE FROM docentes WHERE dni = '$dni'";
            $conn -> query($query);
            if($conn -> errno){
                throw new Exception($conn->error);
            } else {
                $_SESSION['message'] = "Docente Eliminado Correctamente";
                $_SESSION['message-type'] = "success";
            }
        }catch(Exception $ex){
            $_SESSION['badRequestError']=($ex->getMessage());
        }
    }

    if(isset($_POST['create-teacher'])){
        try{
            unset($_SESSION['badRequestError']);
            if(isset($_POST['dni']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])){
                $dni = $_POST['dni'];
                $nombre = $_POST['name'];
                $apellido = $_POST['lastname'];
                $email = $_POST['email'];
                $contraseña = 'abc123';
                
                $excepDni=excepciones($email,$conn,$query,$result);
                $excepDni=excepcionDNI($dni,$conn,$query,$result);
                $query = "INSERT INTO docentes(dni, nombre, apellido, email, contraseña) VALUES ('$dni', '$nombre', '$apellido', '$email', '$contraseña')";
                $conn -> query($query);

                if($conn-> errno){
                    throw new Exception($conn->error);
                } else {
                    $_SESSION['message'] = "Docente creado correctamente";
                    $_SESSION['message-type'] = "success";
                }
            } else {
                throw new Exception('Faltan campos requeridos');
            }
        }catch(Exception $ex){
            $_SESSION['badRequestError']=($ex->getMessage());
        }
    }

    if(isset($_POST['edit-teacher'])){
        try{
            if(isset($_POST['dni']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])){
                $dni = $_POST['dni'];
                $nombre = $_POST['name'];
                $apellido = $_POST['lastname'];
                $email = $_POST['email'];
                
                $query = "UPDATE docentes SET dni = '$dni' , nombre = '$nombre', apellido = '$apellido', email = '$email' WHERE dni='$dni'";
                $conn -> query($query);
                if($conn-> errno){
                    throw new Exception($conn->error);
                } else {
                    $_SESSION['message'] = "Docente actualizado correctamente";
                    $_SESSION['message-type'] = "success";
                }
            } else {
                throw new Exception('Faltan campos requeridos');
            }
        }catch(Exception $ex){
            $_SESSION['badRequestError']=($ex->getMessage());
        }
    }

    
        

}else{
    $_SESSION['badRequestError'] = "No tiene los permisos necesarios para realizar esta acción";
}

function excepciones($email,$conn,$query,$result){
    $query = "SELECT * FROM docentes WHERE email = '$email'";
    $result = $conn -> query($query);
    if (mysqli_num_rows($result) > 0){
        throw new Exception('Ya existe una persona con este email');
    }else{
        return true;
    }
}

function excepcionDNI($dni,$conn,$query,$result){
    $query = "SELECT * FROM docentes WHERE dni = '$dni'";
    $result = $conn -> query($query);
    if (mysqli_num_rows($result) > 0){
        throw new Exception('Ya existe una persona con este dni');
    }else{
        return true;
    }
}




header('Location: '.$namespace.'views/admins/CRUD/teachers.php');




?>