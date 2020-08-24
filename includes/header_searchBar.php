<?php 
$namespace = "http://localhost/Entornos-Graficos_TP-Final/";

if(isset($_POST['searchBar'])){
    if(isset($_POST['searchInput'])){
        $_SESSION['searchBar'] = $_POST['searchInput'];
    }
}

if (isset($_GET['unsetSearchBar'])){
    $filter = $_GET['unsetSearchBar'];
    if (isset($_SESSION[$filter])){
        unset($_SESSION[$filter]);
        $url = strtok($_SERVER['PHP_SELF'], '?');
        header('Location: '.$url);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo de Consultas</title>

    <!-- Boostrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/bdd7793af3.js" crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<!-- NavBar -->
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <div class="col-2">
                <a class="navbar-brand" href="<?= $namespace?>">
                    <img src="https://logosrated.net/wp-content/uploads/parser/UTN-Logo-1.png" width="40" height="40" class="d-inline-block align-top" alt="Logo UTN" loading="lazy">
                </a>
            </div>
            <div class="col-3">
                <a class="navbar-brand h1" href="<?= $namespace?>">Modulo de Aviso de Consultas</a>
            </div>
            <div class="col-5">
                <form class="form-inline my-2 my-lg-0" action="" method="POST">
                    <input class="form-control mr-sm-2" type="search" name="searchInput" value="<?= isset($_SESSION['searchBar'])? $_SESSION['searchBar'] : ""?>" placeholder="Search" required aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" name="searchBar" type="submit">Buscar</button>
<?php
    if(isset($_SESSION['searchBar'])){
?>
            <a href="<?= $_SERVER['PHP_SELF']?>?unsetSearchBar=searchBar" class="btn btn-outline-danger my-2 my-sm-0">Quitar</a>
<?php
    }
?>
                </form>
            </div>
            <div class="col-1">
                <a class="nav-link" href="<?= $namespace?>profile.php">
                    <i class="fa fa-user fa-3x" aria-hidden="true" style="color:black"></i>
                </a>
            </div>
        </div>
    </nav>
