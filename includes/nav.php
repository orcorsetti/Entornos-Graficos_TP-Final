<?php if(isset($_SESSION['user'])){ 
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
      <ul class="navbar-nav">
        <?php
        if(strcmp($_SESSION['user-type'],"student") == 0){
        ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= $namespace?>views/students/list_classes.php">Listado de Consultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $namespace?>views/students/requested_class.php">Consultas Solicitadas</a>
            </li>
        <?php
        } elseif (strcmp($_SESSION['user-type'],"teacher") == 0) {
        ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= $namespace?>views/teachers/classes_calendar.php">Calendario de Consultas</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="activeClasses" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Consultas Activas
                </a>
                <div class="dropdown-menu" aria-labelledby="activeClasses">
                <a class="dropdown-item" href="<?= $namespace?>views/teachers/approved_classes.php">Consultas Confirmadas</a>
                <a class="dropdown-item" href="<?= $namespace?>views/teachers/requested_classes.php">Consultas Pendientes</a>
                <a class="dropdown-item" href="<?= $namespace?>views/teachers/blocked_classes.php">Consultas Bloqueadas</a>
                </div>
            </li>
        <?php
        } elseif(strcmp($_SESSION['user-type'],"admin") == 0){
        ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="activeClasses" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Tablas Generales
                </a>
                <div class="dropdown-menu" aria-labelledby="activeClasses">
                    <a class="dropdown-item" href="<?= $namespace?>views/admins/CRUD/administrator.php">Administradores</a>
                    <a class="dropdown-item" href="<?= $namespace?>views/admins/CRUD/students.php">Alumnos</a>
                    <a class="dropdown-item" href="<?= $namespace?>views/admins/CRUD/subjects.php">Materias</a>
                    <a class="dropdown-item" href="<?= $namespace?>views/admins/CRUD/teachers.php">Profesores</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $namespace?>views/admins/list_classes.php">Listado de Consultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $namespace?>views/admins/update_classes.php">Actualizar Consultas</a>
            </li>
        <?php
        }

      ?>
      </ul>
  </div>
</nav>
<?php }
?>