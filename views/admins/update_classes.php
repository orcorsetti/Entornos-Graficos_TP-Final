<?php
    include('../../database/db.php');
    include('../../includes/header.php');
    include('../../includes/nav.php');
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $namespace?>index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Actualizar Consultas</li>
        </ol>
    </nav>
</div>
<?php
if(isset($_SESSION['updateError'])){
?>
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> <?= $_SESSION['updateError'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
<?php
            unset($_SESSION['updateError']);
        }
if(isset($_SESSION['message'])){
?>
<div class="container">
<div class="container">
                <div class="alert alert-<?= $_SESSION['message-type']?> alert-dismissible fade show" role="alert">
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
if(isset($_SESSION['failedUpdates'])){
    $failedUpdates = $_SESSION['failedUpdates'];
?>
<div class="container">
    <h3>Consultas Erroneas</h3>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Codigo Materia</th>
            <th>DNI Profesor</th>
            <th>Dia de la semana</th>
            <th>Hora</th>
            <th>Lugar</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach ($failedUpdates as $row) {
?>
    <tr>
        <td><?= $row[0]?></td>
        <td><?= $row[1]?></td>
        <td><?= $row[2]?></td>
        <td><?= $row[3]?></td>
        <td><?= $row[4]?></td>
    </tr>
<?php
    }
?>
    </tbody>
    </table>
</div>
<?php
} else {
?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Actualizar Consultas</h1>
        </div>
        <div class="card-body">
            <form action="<?= $namespace?>controllers/admins/update_consults.php" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="consultsFile">Adjuntar Archivo (Formatos: .xls, .xlsx, .ods, .xltx y .ots)</label>
                    <input type="file" accept=".xls, .xlsx, .ods, .xltx, .ots" class="form-control-file" name="consultsFile" required id="consultsFile">
                </div>
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-primary" name="importConsults">Actualizar</button>
                </div>
            </form>
        </div>  
    </div>
    <h4>Formato Predefinido</h3>
    <div class="col-6">
        <table class="table table-bordered table-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Codigo Materia</th>
                    <th>DNI Profesor</th>
                    <th>Dia de la semana</th>
                    <th>Hora</th>
                    <th>Lugar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2</td>
                    <td>40363860</td>
                    <td>1</td>
                    <td>15:00</td>
                    <td>5to Piso</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>35698740</td>
                    <td>5</td>
                    <td>08:00</td>
                    <td>Sala de Profesores</td>
                </tr>
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
    }
    include('../../includes/footer.php');
?>