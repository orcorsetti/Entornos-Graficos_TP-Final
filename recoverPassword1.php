<?php
include('./includes/header.php');
include('./includes/nav.php');
require('database/db.php');
if (!isset($_SESSION['CODIGO'])) {
    if(!empty($_POST)){
        $code = ($_POST['codigo']);
        $_SESSION['CODIGO']="$code";
    }
}else{
    $code = $_SESSION['CODIGO'];
}

$query="SELECT * FROM `docentes` WHERE recupera_contraseña='$code' ";
$result=$conn->query($query) or die($conn->error);

$query="SELECT * FROM `administradores` WHERE recupera_contraseña='$code' ";
$result2=$conn->query($query) or die($conn->error);

if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result2) > 0) {
    unset($password1,$password2);
    ?>
    <div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Recuperar contraseña
                </div>
                <div class="card-body">
                    <form action="recoverPassword1.php" name="f1" method="post">
                        <div class="from-group">
                            <label for="contraseña1">Nueva contraseña</label>
                            <input required type="password"  name="contraseña1" id="contraseña1" class="form-control">
                            <label for="contraseña2">Repita la nueva contraseña</label>
                            <input required type="password" name="contraseña2" id="contraseña2" class="form-control">
                        </div>    <br>
                        <button type="submit" class="btn btn-primary btn-block" name="admin-teacher-recover" >Cambiar</button>
                    </form>
                </div>
            </div>       
        </div>
    </div>
    </div>
  
<?php
    if(isset($_REQUEST['admin-teacher-recover']) && isset($_REQUEST['contraseña1']) && isset($_REQUEST['contraseña2'])){
        $password1 = $_REQUEST['contraseña1'];
        $password2 = $_REQUEST['contraseña2'];
        if($password1==$password2){
            $_SESSION['Contraseña']="$password1";
            header("Location:recoverPassword2.php");
        }else{
            echo('Las contraseñas no coinciden');
        }
    }

}else{
    echo('Código incorrecto');
    ?>
    <div class="container">
        <a href="index.php" class="btn btn-primary btn-block" role="button">Volver al menu principal</a>
    </div>
    <?php
}
    

include('./includes/footer.php')
?>









