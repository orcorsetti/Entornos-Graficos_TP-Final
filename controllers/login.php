<?php
  require('../database/db.php');

    if(isset($_POST['student-login'])){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
    
            $query = "SELECT * FROM alumnos WHERE email='$email'";
            $user = $conn->query($query) or die($conn->error);
            if($user->num_rows === 0){
                $_SESSION['loginError'] = "El email del alumno no se encuentra cargado, comuníquese con el departamento";
            }
            $user = $user->fetch_assoc();
            $_SESSION['user'] = $user['legajo'];
            $_SESSION['user-type'] = "student";
        } else {
            $_SESSION['loginError'] = "Falta un campo requerido";
        }
        header('Location: '. $_SERVER['HTTP_REFERER'] );
    }

    if(isset($_POST['admin-teacher-login'])){
        if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['user-type'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userType = $_POST['user-type'];

            if($userType === "admin"){
                $query = "SELECT * FROM administradores WHERE email='$email' AND contraseña='$password'";
            }
            if($userType === "teacher"){
                $query = "SELECT * FROM docentes WHERE email = '$email' AND contraseña = '$password'";
            }
            if(isset($query)){
                $user = $conn -> query($query);
                if($user -> num_rows === 0){
                    $_SESSION['loginError'] = "El usuario o contraseña ingresado es incorrecto";
                }
                $user = $user -> fetch_assoc();
                $_SESSION['user'] = $user['dni'];
                $_SESSION['user-type'] = $userType;
            } else {
                $_SESSION['loginError'] = "No ha ingresado un rol correcto.";
            }
        } else {
            $_SESSION['loginError'] = "Falta un campo requerido";
        }
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

?>