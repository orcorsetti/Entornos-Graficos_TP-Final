<?php
include('../database/db.php');

if($_SESSION['user-type']=="admin"){

    if(isset($_GET['deletedID'])){
        try{
            $cod_mat = $_GET['deletedID'];
            $query = "DELETE FROM materias WHERE cod_mat = '$cod_mat'";
            $conn -> query($query);
            if($conn -> errno){
                throw new Exception($conn->error);
            } else {
                $_SESSION['message'] = "Materia Eliminada Correctamente";
                $_SESSION['message-type'] = "success";
            }
        }catch(Exception $ex){
            $_SESSION['badRequestError']=($ex->getMessage());
        }
    }

    if(isset($_POST['create-subject'])){
        try{
            unset($_SESSION['badRequestError']);
            if(isset($_POST['cod_mat']) && isset($_POST['name']) && isset($_POST['age'])){
                $cod_mat = $_POST['cod_mat'];
                $nombre = $_POST['name'];
                $año_cursado = $_POST['age'];
                
                $excep=excepciones($cod_mat,$conn,$query,$result);
                $excep=excepcionNAME($nombre,$conn,$query,$result);
                $query = "INSERT INTO materias(cod_mat, nombre, año_cursado) VALUES ('$cod_mat', '$nombre', '$año_cursado')";
                $conn -> query($query);

                if($conn-> errno){
                    throw new Exception($conn->error);
                } else {
                    $_SESSION['message'] = "Materia creada correctamente";
                    $_SESSION['message-type'] = "success";
                }
            } else {
                throw new Exception('Faltan campos requeridos');
            }
        }catch(Exception $ex){
            $_SESSION['badRequestError']=($ex->getMessage());
        }
    }

    if(isset($_POST['edit-subject'])){
        try{
            if(isset($_POST['cod_mat']) && isset($_POST['name']) && isset($_POST['age'])){
                $cod_mat = $_POST['cod_mat'];
                $nombre = $_POST['name'];
                $año_cursado = $_POST['age'];

                $query = "UPDATE materias SET cod_mat = '$cod_mat' , nombre = '$nombre', año_cursado = '$año_cursado' WHERE cod_mat='$cod_mat'";
                $conn -> query($query);
                if($conn-> errno){
                    throw new Exception($conn->error);
                } else {
                    $_SESSION['message'] = "Materia actualizada correctamente";
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

function excepciones($cod_mat,$conn,$query,$result){
    $query = "SELECT * FROM materias WHERE cod_mat = '$cod_mat'";
    $result = $conn -> query($query);
    if (mysqli_num_rows($result) > 0){
        throw new Exception('Ya existe una materia con este codigo');
    }else{
        return true;
    }
}

function excepcionNAME($nombre,$conn,$query,$result){
    $query = "SELECT * FROM materias WHERE nombre = '$nombre'";
    $result = $conn -> query($query);
    if (mysqli_num_rows($result) > 0){
        throw new Exception('Ya existe una materia con este nombre');
    }else{
        return true;
    }
}


header('Location: '.$namespace.'views/admins/CRUD/subjects.php');

?>