<?php
    include('./database/db.php');
    $_SESSION['searchBar']="";
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
    <div class="row">
        <div class="col-8">
            <h1 class="h2 card-title"> <small> Bienvenido/a <?=$nombre?> <?=$apellido?></small></h1>
        </div>

<?php
        }
?>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Consultas Confirmadas para hoy</div>
            </div>
            <div class="card-body">
                <ul class="list-group"></ul>
<?php
    if($_SESSION['user-type'] === "teacher"){
        $queryAccDir = "SELECT DISTINCT mat.nombre AS materia, insc.legajo, con.hora, con.lugar FROM docentes doc
        INNER JOIN consultas con ON con.dni=doc.dni
        INNER JOIN incripciones insc ON insc.cod_con=con.cod_con
        INNER JOIN materias mat ON mat.cod_mat = con.cod_mat
        WHERE doc.dni='".$_SESSION['user']."' AND insc.fecha_con = '".date("Y-m-d")."' 
            AND insc.estado = 'Confirmada'";    
    }
    if($_SESSION['user-type'] === "student"){
        $queryAccDir = "SELECT DISTINCT mat.nombre AS materia, doc.nombre, doc.apellido, insc.legajo, con.hora, con.lugar
                            FROM consultas con
                            INNER JOIN incripciones insc ON con.cod_con=insc.cod_con
                            INNER JOIN materias mat ON mat.cod_mat=con.cod_mat
                            INNER JOIN docentes doc ON doc.dni=con.dni
                            WHERE insc.legajo='".$_SESSION['user']."' 
                                AND insc.fecha_con='".date("Y-m-d")."'
                                AND insc.estado = 'Confirmada'";
    }
    
    if(isset($queryAccDir)){
        $result = $conn -> query($queryAccDir) or die($conn -> error);
        if($result-> num_rows == 0) {
?>
                <li class="list-group-item">No hay consultas confirmadas</li>
<?php
            
        } else {
            while($row = $result -> fetch_assoc()){
?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            <small><?= $row['materia']?></small>
                        </div>
                    </div>
        <?php
            if($_SESSION['user-type']==="student"){
        ?>
                    <div class="row">
                        <div class="col">
                            <small><?= $row['nombre']." ".$row['apellido']?></small>
                        </div>
                    </div>
        <?php
            }
        ?>
                    <div class="row content-align-left">
                        <div class="col-sm">
                            <small><?= $row['hora']?></small>
                        </div>
                        <div class="col-sm">
                            <small><?= $row['lugar']?></small>
                        </div>
                    </div>
                </li>
<?php
            }
        }
    }
}

    ?>
            </div>
            </div>
        </div>
    </div>
</div>

<?php

    include('./includes/footer.php')
?>