<?php
include('../../../database/db.php');
include('../../../includes/header.php');
include('../../../includes/nav.php');

if(!strcmp($_SESSION['user-type'], "admin") == 0){
?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> No tiene permiso para ingresar a esta sección.
        </div>
    </div>
<?php
    } else {
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $namespace?>index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= $namespace?>/views/admins/CRUD/crud-menu.php">Tablas Generales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tabla de Administradores</li>
        </ol>
    </nav>
</div>
<?php
    $query = "SELECT * FROM docentes";
    $result = $conn -> query($query);
    if($conn->errno){
?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> Falló la conexión con la Base de Datos.
        </div>
    </div>
<?php
    } else {
        if(isset($_SESSION['badRequestError'])){
?>
<div class="container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> <?= $_SESSION['badRequestError']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php
            unset($_SESSION['badRequestError']);
        }
        if(isset($_SESSION['message'])){
?>
<div class="container">
    <div class="alert alert-<?= $_SESSION['message-type']?> alert-dismissible fade show" role="alert">
        <strong></strong> <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php
            unset($_SESSION['message']);
            unset($_SESSION['message-type']);
        }
?>

<div class="container">
    <div class="row justify-content-md-center align-items-center">
        <div class="col-6 ">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#createModal">
                Agregar Docente
            </button>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
<?php
    while($row = $result -> fetch_assoc()){
?>
            <tr>
                <td><?= $row['dni']?></td>
                <td><?= $row['nombre']?></td>
                <td><?= $row['apellido']?></td>
                <td><?= $row['email']?></td>
                <td>
                    <a href="<?= $namespace?>views/admins/CRUD/teachers.php?editedID=<?= $row['dni']?>" class="btn btn-outline-primary">
                        <i class="fas fa-pen fa-1x"></i>
                    </a>
                    <a href="<?= $namespace?>controllers/admins/teacher_controller.php?deletedID=<?= $row['dni']?>" class="btn btn-outline-danger">
                        <i class="fas fa-trash" style="color: red;"></i>
                    </a>
                </td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>
</div>
<!-- Modal Crear -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Agregar Docente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="<?= $namespace?>controllers/admins/teacher_controller.php" method="post">
        <div class="modal-body">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="lasname">Apellido:</label>
                <input type="text" name="lastname" id="lastname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" name="create-teacher" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
    }
}
include('../../../includes/footer.php');
?>
<?php
    if(isset($_GET['editedID'])){
        $id = $_GET['editedID'];
        $query = "SELECT * FROM docentes WHERE dni = '$id' ";

        $result = $conn -> query($query);
        if($conn->errno){
            $_SESSION['badRequestError'] = "Error al obtener el recurso";
            header('Location: $namespaceviews/admins/CRUD/teachers.php');
        }
        $user = $result->fetch_assoc();
?>
<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Editar Docente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="<?= $namespace?>controllers/admins/teacher_controller.php" method="post" class="">
        <div class="modal-body">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" class="form-control" value="<?= $user['dni']?>" readonly="readonly" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $user['nombre']?>" required>
            </div>
            <div class="form-group">
                <label for="lasname">Apellido:</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $user['apellido']?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" class="form-control" value="<?= $user['email']?>" readonly="readonly" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" name="edit-teacher" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
    $('#editModal').modal('show');
</script>
<?php
    }