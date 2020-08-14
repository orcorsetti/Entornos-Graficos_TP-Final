<?php
    include('../../database/db.php');
    include('../../includes/header.php');
    include('../../includes/nav.php');

if(!strcmp($_SESSION['user-type'], "student") == 0){
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
            <li class="breadcrumb-item active" aria-current="page">Listado de Consultas</li>
        </ol>
    </nav>
</div>
<?php

$where='';
if(isset($_POST['buscar'])){
    $filtroMateria = $_POST['FiltroMateria1'];
    $filtroDocente = $_POST['FiltroDocente'];
    $filtroAño = $_POST['FiltroAño'];
    if($_POST['FiltroMateria1']!='Sin filtro' && $_POST['FiltroDocente']=='Sin filtro' && $_POST['FiltroAño']=='Sin filtro'){
        $where="WHERE materias.nombre like'".$filtroMateria."%'";
    }else if($_POST['FiltroMateria1']!='Sin filtro' && $_POST['FiltroDocente']!='Sin filtro' && $_POST['FiltroAño']=='Sin filtro'){
        $where="WHERE docentes.apellido like'".$filtroDocente."%' and materias.nombre like'".$filtroMateria."%'";
    }else if($_POST['FiltroMateria1']!='Sin filtro' && $_POST['FiltroDocente']!='Sin filtro' && $_POST['FiltroAño']!='Sin filtro'){
        $where="WHERE docentes.apellido like'".$filtroDocente."%' and materias.nombre like'".$filtroMateria."%' and materias.año_cursado =".$filtroAño;
    }else if($_POST['FiltroMateria1']=='Sin filtro' && $_POST['FiltroDocente']!='Sin filtro' && $_POST['FiltroAño']=='Sin filtro'){
        $where="WHERE docentes.apellido like'".$filtroDocente."%'";
    }else if($_POST['FiltroMateria1']=='Sin filtro' && $_POST['FiltroDocente']=='Sin filtro' && $_POST['FiltroAño']!='Sin filtro'){
        $where="WHERE materias.año_cursado =".$filtroAño;
    }else if($_POST['FiltroMateria1']=='Sin filtro' && $_POST['FiltroDocente']!='Sin filtro' && $_POST['FiltroAño']!='Sin filtro'){
        $where="WHERE docentes.apellido like'".$filtroDocente."%' and materias.año_cursado =".$filtroAño;
    }else if($_POST['FiltroMateria1']!='Sin filtro' && $_POST['FiltroDocente']=='Sin filtro' && $_POST['FiltroAño']!='Sin filtro'){
        $where="WHERE materias.nombre like'".$filtroMateria."%' and materias.año_cursado =".$filtroAño;
    }else{
        $where='';
    }
}
if(isset($_POST['buscar1'])){
    if(!empty($_POST['FiltroMateria'])){
        $fm=$_POST['FiltroMateria'];
        $where="WHERE materias.nombre like'".$fm."%'";
    }else{
        $where='';
    }
}
$query = "SELECT DISTINCT materias.nombre, docentes.nombre, docentes.apellido,consultas.dia_semana,consultas.hora,consultas.lugar FROM `consultas` INNER JOIN materias ON materias.cod_mat=consultas.cod_mat INNER JOIN docentes ON docentes.dni=consultas.dni $where";
$result = $conn -> query($query);
$query1 = "SELECT DISTINCT nombre FROM `materias` ";
$result1 = $conn -> query($query1);
$query2 = "SELECT DISTINCT nombre, apellido FROM `docentes`";
$result2 = $conn -> query($query2);
   
    if($conn->errno){
?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> Falló la conexión con la Base de Datos.
        </div>
    </div>
<?php
    } else {     
?>
<form method="POST">
    <div class="container">
    <div class="row">
        <div class="col-">
            <input class="form-control" name="FiltroMateria" id="FiltroMateria" type="FiltroMateria" placeholder="Buscar por materia">
            </div>
        <div class="col-sm">
        <button type="submit" class="btn btn-primary" name="buscar1">Filtrar</button>
        </div>

        </div>
        <br>
    </div>
    </form>

<div class="container">
<div class="row">
    <div class="col-">
        <div class="card">
            <div class="card-header">
                Filtros
                <br>
                <h4>Materias</h4>
                <form method="POST">
                <?php
            while($row1 = $result1 -> fetch_array()){
        ?>
                
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="FiltroMateria1" id="FiltroMateria1" value="<?= $row1[0]?>" checked>
                        <label class="form-check-label" for="exampleRadios">
                    <?= $row1[0]?>
                        </label>
                    </div>

                <?php
                    }
                ?>
                
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="FiltroMateria1" id="FiltroMateria1" value="Sin filtro" checked>
                        <label class="form-check-label" for="exampleRadios">
                    Sin filtro
                        </label>
                    </div>
                    <br>

                <h4>Profesores</h4>
                
                <?php
            while($row2 = $result2 -> fetch_array()){
        ?>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="FiltroDocente" id="FiltroDocente" value="<?= $row2[1]?>" checked>
                        <label class="form-check-label" for="exampleRadios1">
                    <?= $row2[0]?> <?= $row2[1]?>
                        </label>
                    </div>
 
                <?php
                    }
                ?>
                <div class="form-check">
                        <input class="form-check-input" type="radio" name="FiltroDocente" id="FiltroDocente" value="Sin filtro" checked>
                        <label class="form-check-label" for="exampleRadios1">
                    Sin filtro
                        </label>
                    </div>
                <br>
               
        <h4>Año</h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="FiltroAño" id="FiltroAño" value=1 checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Primer año
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="FiltroAño" id="FiltroAño" value=2 checked> 
                    <label class="form-check-label" for="exampleRadios2">
                        Segundo año
                    </label>
                    </div>
                    <div class="form-check">
                    
                    <input class="form-check-input" type="radio" name="FiltroAño" id="FiltroAño" value=3 checked>
                    <label class="form-check-label" for="exampleRadios3">
                        Tercer año
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="FiltroAño" id="FiltroAño" value=4 checked>
                    <label class="form-check-label" for="exampleRadios3">
                        Cuarto año
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="FiltroAño" id="FiltroAño" value=5 checked>
                    <label class="form-check-label" for="exampleRadios3">
                        Quinto año
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="FiltroAño" id="FiltroAño" value="Sin filtro" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Sin filtro
                    </label>
                </div>
                <br>
        <div class="col-">
            <button type="submit" class="btn btn-primary" name="buscar">Filtrar</button>
            </div>
        </form>
 
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card">
            <div class="card-header">
                Listado de Consultas
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre Materia</th>
                            <th>Nombre Docente</th>
                            <th>Apellido Docente</th>
                            <th>Dia de consulta</th>
                            <th>Hora consulta</th>
                            <th>Lugar consulta</th>
                            <th>Solicitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                while($row = $result -> fetch_array()){
            ?>
                        <tr>
                            <td><?= $row[0]?></td>
                            <td><?= $row['nombre']?></td>
                            <td><?= $row['apellido']?></td>
                            <td><?= $row['dia_semana']?></td>
                            <td><?= $row['hora']?></td>
                            <td><?= $row['lugar']?></td>
                            <td><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#createModal">
                            Solicitar consulta
                        </button></td>
                        </tr>
            <?php
                }
            ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>
</div>

</div>

<?php
    }
}
    include('../../includes/footer.php');

?>