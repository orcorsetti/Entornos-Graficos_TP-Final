<?php
    include('../../database/db.php');
    include('../../includes/header_searchBar.php');
    include('../../includes/nav.php');
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
    if($_SESSION['user-type']!=="admin"){
?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> No tiene permiso para ingresar a esta sección.
        </div>
    </div>
<?php
    } else {
        $query_select = "SELECT DISTINCT mat.nombre, doc.nombre , doc.apellido, insc.fecha_con, con.hora, con.lugar, con.cod_con FROM consultas con ";
        $query_where = "";
        $query_inner = " 
                        INNER JOIN materias mat ON mat.cod_mat = con.cod_mat 
                        INNER JOIN docentes doc ON doc.dni = con.dni
                        INNER JOIN incripciones insc ON insc.cod_con = con.cod_con";

        if (isset($_GET['setSubjectFilter'])){
            $_SESSION['subjectFilter'] = $_GET['setSubjectFilter'];
        }
        if (isset($_GET['setYearFilter'])) {
            $_SESSION['yearFilter'] = $_GET['setYearFilter'];
        }
        if (isset($_GET['setTeacherFilter'])){
            $_SESSION['teacherFilter'] = $_GET['setTeacherFilter'];
        }
        if (isset($_GET['unsetFilter'])){
            $filter = $_GET['unsetFilter'];
            if (isset($_SESSION[$filter])){
                unset($_SESSION[$filter]);
            }
        }

        if(isset($_SESSION['searchBar'])){
            $query_where = " WHERE (mat.nombre LIKE '%".$_SESSION['searchBar']."%' OR doc.nombre LIKE '%".$_SESSION['searchBar']."%')";
        }

        if(isset($_SESSION['subjectFilter'])){
            if($query_where !== ""){
                $query_where = $query_where." AND mat.nombre = '".$_SESSION['subjectFilter']."'";
            } else {
                $query_where = " WHERE mat.nombre = '".$_SESSION['subjectFilter']."'";
            }
        } else {
            $filterSelect = "SELECT DISTINCT mat.nombre FROM consultas con ";
            $query = $filterSelect.$query_inner.$query_where;
            $subjectFilters = $conn -> query($query) or die($conn->error);
        }


        if(isset($_SESSION['yearFilter'])){
            if($query_where !== ""){
                $query_where = $query_where." AND mat.año_cursado = '".$_SESSION['yearFilter']."'";
            } else {
                $query_where = " WHERE mat.año_cursado = '".$_SESSION['yearFilter']."'";
            }
        } else {
            $filterSelect = "SELECT DISTINCT mat.año_cursado FROM consultas con ";
            $query = $filterSelect.$query_inner.$query_where;
            $yearFilters = $conn -> query($query) or die($conn->error);
        }


        if(isset($_SESSION['teacherFilter'])){
            if($query_where !== ""){
                $query_where = $query_where." AND  doc.dni = '".$_SESSION['teacherFilter']."'";
            } else {
                $query_where = $query_where." WHERE  doc.dni = '".$_SESSION['teacherFilter']."'";
            }
        } else {
            $filterSelect = "SELECT DISTINCT doc.dni FROM consultas con ";
            $query = $filterSelect.$query_inner.$query_where;
            $teacherFilters = $conn -> query($query) or die($conn->error);
             
        }
?>
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">Filtros</div>
                <div class="card-body">
                    <p>Profesor</p>
<?php
    if(isset($_SESSION['teacherFilter'])){
        $filterQuery = "SELECT * FROM docentes WHERE dni = '".$_SESSION['teacherFilter']."'";
        $result = $conn->query($filterQuery);
        $teacher = $result -> fetch_assoc();
        $teacherName = $teacher['nombre']." ".$teacher['apellido'];
?>
        <a href="<?= $namespace?>views/admins/list_classes.php?unsetFilter=teacherFilter" class="list-group-item list-group-item-action active">
            <small>
                <?= $teacherName?>
            </small>
            <i class="fas fa-times"  aria-hidden="true" style="color:white"></i>
        </a>
<?php
    } else {
        while($row = $teacherFilters->fetch_assoc()) {
            $filterQuery = "SELECT * FROM docentes WHERE dni = '".$row['dni']."'";
            $result = $conn->query($filterQuery);
            $teacher = $result -> fetch_assoc();
            $teacherDni = $teacher['dni'];
            $teacherName = $teacher['nombre']." ".$teacher['apellido'];
?>
        <a href="<?= $namespace ?>views/admins/list_classes.php?setTeacherFilter=<?=$teacherDni?>" class="list-group-item list-group-item-action">
            <small>
                <?= $teacherName ?>
            </small>
        </a>
<?php
        }
    }
?>
    <p>Año de Cursado</p>
<?php
    if(isset($_SESSION['yearFilter'])){
?>
        <a href="<?= $namespace?>views/admins/list_classes.php?unsetFilter=yearFilter" class="list-group-item list-group-item-action active"> 
            <small> 
                <?= $_SESSION['yearFilter']?>
            </small>
            <i class="fas fa-times"  aria-hidden="true" style="color:white"></i>
        </a>
<?php
    } else {
        while($row = $yearFilters->fetch_assoc()) {
?>
        <a href="<?= $namespace ?>views/admins/list_classes.php?setYearFilter=<?=$row['año_cursado']?>" class="list-group-item list-group-item-action">
            <small>
                <?= $row['año_cursado'] ?>
            </small>
    </a>
<?php
        }
    }
?>
    <p>Materia</p>
<?php
    if(isset($_SESSION['subjectFilter'])){
?>
        <a href="<?= $namespace?>views/admins/list_classes.php?unsetFilter=subjectFilter" class="list-group-item list-group-item-action active"> 
            <small> 
                <?= $_SESSION['subjectFilter']?>
            </small>
            <i class="fas fa-times"  aria-hidden="true" style="color:white"></i>
        </a>
<?php
    } else {
        while($row = $subjectFilters->fetch_assoc()) {
?>
        <a href="<?= $namespace ?>views/admins/list_classes.php?setSubjectFilter=<?=$row['nombre']?>" class="list-group-item list-group-item-action">
            <small>
                <?= $row['nombre'] ?>
            </small>
    </a>
<?php
        }
    }
?>
            </div>
        </div>
    </div>

<?php
        $query = $query_select.$query_inner.$query_where;
        $result = $conn->query($query);
        
        if($conn -> errno){
?>
    <div class="col-8">
        <div class="alert alert-danger" role="alert">
            <strong>Error en la conexión con la Base de Datos: </strong> <?= $conn->error?>.
        </div>
    </div>
<?php
        } else {
            if($result-> num_rows == 0){
?>
    <div class="col-8">
        <div class="alert alert-warning" role="alert">
            No hay consultas que coincidan.
        </div>
    </div>
<?php
            } else {
?>
    <div class="col-8">
        <div class="card">
            <div class="card-header">Lista de Consultas</div>
            <div class="tbody p-1">
            <table class="table table-sm p-1">
                <thead class="bg-primary text-white">
                    <th>Materia</th>
                    <th>Profesor</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Lugar</th>
                    <th>Alumnos</th>
                </thead>
                <tbody>
<?php
        while($row = $result -> fetch_array()){
?>
                    <tr>
                        <td> <small><?=$row[0]?></small></td>
                        <td> <small><?=$row[1]." ".$row[2]?></small></td>
                        <td> <small><?=$row[3]?></small></td>
                        <td> <small><?=$row[4]?></small></td>
                        <td> <small><?=$row[5]?></small></td>
                        <td> 
                            <a href="<?= $_SERVER['PHP_SELF']?>?consult=<?=$row[6]?>&date=<?=$row[3]?>" class="btn btn-link">
                                <small>Ver Alumnos</small>
                            </a>
                        </td>
                    </tr>
<?php

?>
<?php } ?>
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
}

include('../../includes/footer.php');
         
    if(isset($_GET['date'])&&isset($_GET['consult'])){
?>

<div class="modal fade" id="studentsModal" tabindex="-1" aria-labelledby="studentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">  
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentsModalLabel">Alumnos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <ul class="list-group">
<?php
    $studentsQuery = "SELECT insc.legajo, al.nombre, al.apellido FROM incripciones insc 
                        INNER JOIN alumnos al ON al.legajo = insc.legajo 
                        WHERE insc.cod_con = '".$_GET['consult']."' AND insc.fecha_con = '".$_GET['date']."'";
    $resultStudents = $conn -> query($studentsQuery);
    while($student = $resultStudents->fetch_array()){
?>
        <li class="list-group-item"><?= $student[0]?> - <?=$student[1]." ".$student[2]?></li>
<?php
    }
?>
      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $('#studentsModal').modal('show');
</script>
<?php
            }
?>