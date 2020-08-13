<?php
include('./includes/header.php');
include('./includes/nav.php');
require('database/db.php');

$code=($_SESSION['CODIGO']);
$password1=$_SESSION['Contraseña'];

$query="UPDATE `docentes` SET `contraseña` = '$password1' WHERE `docentes`.`recupera_contraseña` ='$code'";
$conn->query($query) or die($conn->error);
$query="UPDATE `administradores` SET `contraseña` = '$password1' WHERE `administradores`.`recupera_contraseña` ='$code'";
$conn->query($query) or die($conn->error);

echo('Contraseña cambiada exitosamente');
?>
<div class="container">
    <a href="index.php" class="btn btn-primary btn-block" role="button">Volver al menu principal</a>
</div>
<?php

include('./includes/footer.php')
?>