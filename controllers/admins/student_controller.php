<?php
include('../../database/db.php');

if($_SESSION['user-type']=="admin"){

    if(isset($_GET['deletedID'])){
        try{
            $legajo = $_GET['deletedID'];
            $query = "DELETE FROM alumnos WHERE legajo = '$legajo'";
            $conn -> query($query);
            if($conn -> errno){
                throw new Exception($conn->error);
            } else {
                $_SESSION['message'] = "Alumno Eliminado Correctamente";
                $_SESSION['message-type'] = "success";
            }
        }catch(Exception $ex){
            $_SESSION['badRequestError']=($ex->getMessage());
        }
    }

    if(isset($_POST['create-student'])){
        try{
            unset($_SESSION['badRequestError']);
            if(isset($_POST['legajo']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])){
                $legajo = $_POST['legajo'];
                $nombre = $_POST['name'];
                $apellido = $_POST['lastname'];
                $email = $_POST['email'];
                
                $excep=excepciones($email,$conn,$query,$result);
                $excep=excepcionDNI($legajo,$conn,$query,$result);
                $query = "INSERT INTO alumnos(legajo, nombre, apellido, email) VALUES ('$legajo', '$nombre', '$apellido', '$email')";
                $conn -> query($query);

                if($conn-> errno){
                    throw new Exception($conn->error);
                } else {
                    $_SESSION['message'] = "Alumno creado correctamente";
                    $_SESSION['message-type'] = "success";
                }
            } else {
                throw new Exception('Faltan campos requeridos');
            }
        }catch(Exception $ex){
            $_SESSION['badRequestError']=($ex->getMessage());
        }
    }

    if(isset($_POST['edit-student'])){
        try{
            if(isset($_POST['legajo']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email'])){
                $legajo = $_POST['legajo'];
                $nombre = $_POST['name'];
                $apellido = $_POST['lastname'];
                $email = $_POST['email'];

                $query = "UPDATE alumnos SET legajo = '$legajo' , nombre = '$nombre', apellido = '$apellido', email = '$email' WHERE legajo='$legajo'";
                $conn -> query($query);
                if($conn-> errno){
                    throw new Exception($conn->error);
                } else {
                    $_SESSION['message'] = "Alumno actualizado correctamente";
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
    $query = "SELECT * FROM alumnos WHERE email = '$email'";
    $result = $conn -> query($query);
    if (mysqli_num_rows($result) > 0){
        throw new Exception('Ya existe una persona con este email');
    }else{
        return true;
    }
}

function excepcionDNI($legajo,$conn,$query,$result){
    $query = "SELECT * FROM alumnos WHERE legajo = '$legajo'";
    $result = $conn -> query($query);
    if (mysqli_num_rows($result) > 0){
        throw new Exception('Ya existe una persona con este legajo');
    }else{
        return true;
    }
}


header('Location: '.$namespace.'views/admins/CRUD/students.php');

?>