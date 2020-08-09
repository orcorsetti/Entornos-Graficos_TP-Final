<?php
    if(isset($_SESSION['loginError'])){
?>
    <div class="container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error: </strong> <?= $_SESSION['loginError'];?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php
    unset($_SESSION['loginError']);
    }
?>

<div class="container">
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Portal Alumno
            </div>
            <div class="card-body">
                <form action="controllers/login.php" method="post">
                    <div class="form-group">
                        <label for="email"> Email</label>
                        <input type="email" name="email" id="email" required class="form-control" placeholder="Inserte su Email">
                    </div>
                    <button type="submit" name="student-login" class="btn btn-block btn-primary">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                Portal Docente/Administrador
            </div>
            <div class="card-body">
                <form action="controllers/login.php" method="post">
                    <div class="from-group">
                        <label for="email">Email</label>
                        <input required type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" required class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user-type" id="user-type" value="teacher" checked>
                                    <label class="form-check-label" for="user-type">
                                        Docente
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user-type" id="user-type" value="admin" checked>
                                    <label class="form-check-label" for="user-type">
                                        Administrador
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="admin-teacher-login">Ingresar</button>
                </form>
                <a href="#" class="btn btn-link" data-toggle="modal" data-target="#modalPassword">He olvidado mi contraseña</a>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalPasswordTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasswordTitle">Recuperación de Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="recoverPassword.php" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required class="form-control" placeholder="Ingrese el email de su cuenta">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>
</div>