<!-- Aca se genera la recuperacion y se envia el mail -->
<!-- Despues se vuelve muestra un formulario para ingresar el codigo y para volver al login -->
<!-- Si el codigo esta bien te muestra un formulario para actualizar la contra -->

<?php
include('./includes/header.php');
include('./includes/nav.php');
require('database/db.php');

if(!empty($_POST)){
    function mt_random_int($min, $max) {
        $integer_part = mt_rand($min, $max - 1);
        return $integer_part;
    }

    $email = ($_POST['email']);
   
    $query="SELECT * FROM `docentes` WHERE email='$email' ";
    $result=$conn->query($query) or die($conn->error);
    unset($_SESSION['CODIGO']);
    if (mysqli_num_rows($result) > 0) {

        $codigo = mt_random_int(1000,10000000);
        $query = "UPDATE `docentes` SET `recupera_contraseña` = $codigo WHERE `docentes`.`email` = '$email';";
        $conn->query($query) or die($conn->error);
        
        $name="Recover Password";
        $asunto="Recover Password";
        $msg = ("Para poder restablecer la contraseña de su cuenta del módulo de consultas ingrese el siguiente código que le damos a continuacion: "."$codigo");
        $header = "From: DptoIngenieria@gmail.com";
        mail($email,$asunto,$msg,$header);
        ?>
        <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Ingresa el codigo de recuperacion que enviamos a tu mail
                    </div>
                    <div class="card-body">
                        <form action="recoverPassword1.php" method="post">
                            <div class="from-group">
                                <label for="codigo">Codigo</label>
                                <input required name="codigo" id="codigo" class="form-control">
                            </div>    <br>
                            <button type="submit" class="btn btn-primary btn-block" name="admin-teacher-recover">Verificar</button>
                            <a href="index.php" class="btn btn-primary btn-block" role="button">Volver al menu principal</a>
                        </form>
                    </div>
                </div>       
            </div>
        </div>
        </div>
        <?php
    }else{
        echo('email incorrecto');
        ?>
        <div class="container">
            <a href="index.php" class="btn btn-primary btn-block" role="button">Volver al menu principal</a>
        </div>
        <?php
    } 
}
include('./includes/footer.php')

?>




