<?php
    include('./database/db.php');
    //session_unset();

    include('./includes/header.php');
    include('./includes/nav.php');

?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>
</div>
<?php

    if(!isset($_SESSION['user'])){
        include('login.php');
    } else{
        $idUser = $_SESSION['user'];
        if(strcmp($_SESSION['user-type'],"student") == 0){
            $query = "SELECT nombre, apellido FROM alumnos WHERE legajo = $idUser";
        } elseif (strcmp($_SESSION['user-type'],"teacher") == 0) {
            $query = "SELECT nombre, apellido FROM docentes WHERE dni = $idUser";
        } elseif (strcmp($_SESSION['user-type'],"admin") == 0) {
            $query = "SELECT nombre, apellido FROM administradores WHERE dni = $idUser";
        }
        $user = $conn->query($query) or die($conn->error);
        if($user->num_rows === 0){
            $_SESSION['loginError'] = "Posee un usuario equivocado, cierre sesion o comuniquese con el departamento";
        } else {
            $user = $user->fetch_assoc();
            $nombre = $user['nombre'];
            $apellido = $user['apellido'];
?>
<div class="container">
        <h1 class="h2 card-title">Bienvenido/a <?=$nombre?> <?=$apellido?></h1>
</div>
<?php
        }
    }

?>

<?php

    include('./includes/footer.php')
?>