<?php
include('database/db.php');
include('includes/header.php');
include('includes/nav.php');
if(!isset($_SESSION['user'])){
?>
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> No tiene permisos para acceder a esta sección.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <a href="<?= $namespace?>" class="btn btn-link">Volver al Login</a>
</div>
<?php
} else {
    if(isset($_SESSION['error'])){
?>
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> <?= $_SESSION['error']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php
    unset($_SESSION['error']);
    }
    if(isset($_SESSION['message'])){
?>
<div class="container">
    <div class="alert alert-<?=$_SESSION['message-type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php
        unset($_SESSION['message']);
        unset($_SESSION['message-type']);
    }
    $id = $_SESSION['user'];
    if($_SESSION['user-type']=="admin"){
        $query = "SELECT * FROM administradores WHERE dni='$id' LIMIT 0,1";
    } elseif ($_SESSION['user-type']=="student") {
        $query = "SELECT * FROM alumnos WHERE legajo='$id' LIMIT 0,1";
    } elseif ($_SESSION['user-type']=="teacher") {
        $query = "SELECT * FROM docentes WHERE dni='$id' LIMIT 0,1";
    }
    if(!isset($query)){
?>
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> No tiene permisos para acceder a esta sección.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <a href="<?= $namespace?>" class="btn btn-link">Volver al Login</a>
</div>
<?php
    header('Location: '.$namespace);
    } else {
        $result = $conn -> query($query);
        if($conn-> errno){
?>
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> Fallo al recuperar los datos del usuario.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <a href="<?= $namespace?>" class="btn btn-link">Volver al Login</a>
</div>
<?php
        }
        if($result -> num_rows > 0){
            $user = $result->fetch_array();
?>
<div class="container">
    <div class="card p-1">
            <div class="card-header">
                <h2 class="card-title h4">Perfil</h2>
            </div>
            <div class="card-body">
<?php
    if($_SESSION['user-type'] == "student"){
?>
            <div class="row p-1">
                <span><strong>Legajo: </strong> <?=$user[0]?></span>
            </div>
<?php   } else{ ?>
            <div class="row p-1">
                <span><strong>DNI: </strong> <?= $user[0]?></span>
            </div>
<?php }?>
            <div class="row p-1">
                <span><strong>Nombre y Apellido: </strong> <?= $user[1]." ".$user[2]?></span>
            </div>
            <div class="row p-1">
                <span><strong>Email: </strong><?= $user[3]?></span>
            </div>
<?php if($_SESSION['user-type']=="admin" || $_SESSION['user-type']=="teacher"){?>
            <div class="row p-1">
                <span><strong>Contraseña: </strong>
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#changePassword">
                Cambiar Constraseña
                </button>
            </div>

<!-- Modal Editar Contraseña -->
<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePassword">Cambiar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= $namespace?>controllers/profile_controller.php" method="post">
        <div class="modal-body">
            <input type="hidden" name="id" value="<?= $user[0] ?>">
            <div class="from-group">
                <label for="old_password">Contraseña anterior</label>
                <input type="password" required placeholder="Ingrese su contraseña anterior" class="form-control" name="old_password" id="old_password">
            </div>
            <div class="from-group">
                <label for="new_password">Nueva contraseña</label>
                <input type="password" required placeholder="Ingrese su nueva contraseña" class="form-control" name="new_password" id="new_password">
            </div>
            <div class="from-group">
                <label for="new_password2">Repita la nueva contraseña</label>
                <input type="password" required placeholder="Reingrese su nueva contraseña" class="form-control" name="new_password2" id="new_password2">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" name="changePassword">Cambiar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php }?>
            </div>
    </div>
</div>
<div class="row justify-content-center p-2">
    <div class="col-2">
        <form action="<?= $namespace?>controllers/profile_controller.php" method="post">
            <button type="submit" name="closeSession" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUser">
                Editar Perfil
        </button>
    </div>
</div>
<?php
        }
    }

?>

<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUser">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= $namespace?>controllers/profile_controller.php" method="post">
        <div class="modal-body">
            <div class="form-group">
<?php
            if($_SESSION['user-type']=="student"){
?>
                <label for="id">Legajo</label>
                <input class="form-control" type="text" name="id" id="id" placeholder="Ingrese su legajo" required value="<?= $user[0]?>">
<?php }else { ?>
                <label for="id">DNI</label>
                <input class="form-control" type="text" name="id" id="id" placeholder="Ingrese su DNI" required value="<?= $user[0]?>">
<?php } ?>
            </div>
            <input type="hidden" name="previous_id" value="<?= $user[0]?>">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" required class="form-control" placeholder="Ingrese su nombre" value="<?= $user[1]?>">
            </div>
            <div class="form-group">
                <label for="lastname">Apellido</label>
                <input type="text" name="lastname" id="lastname" required class="form-control" placeholder="Ingrese su apellido" value="<?= $user[2]?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required class="form-control" placeholder="Ingrese su email" value="<?= $user[3]?>">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" name="editUser">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
}
include('includes/footer.php');
?>