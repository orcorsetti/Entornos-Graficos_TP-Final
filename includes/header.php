<?php
    $namespace = "http://localhost/TP-Sitio/"
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!-- Header -->
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <div class="col-2">
                <a class="navbar-brand" href="http://localhost/TP-Sitio/index.php">
                    <img src="https://logosrated.net/wp-content/uploads/parser/UTN-Logo-1.png" width="40" height="40" class="d-inline-block align-top" alt="Logo UTN" loading="lazy">
                </a>
            </div>
            <div class="col-8">
                <a class="navbar-brand h1" href="http://localhost/TP-Sitio/index.php">Modulo de Aviso de Consultas</a>
            </div>
<?php
    if(isset($_SESSION['user'])){
?>
            <div class="col-2">
                <a class="nav-link" href="profile.php">
                    <i class="fa fa-user fa-3x" aria-hidden="true" style="color:black"></i>
                </a>
            </div>
<?php 
    }
?>
        </div>
    </nav>
