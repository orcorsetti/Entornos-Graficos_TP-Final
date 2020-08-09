<?php
    include('../../database/db.php');
    include('../../includes/header.php');
    include('../../includes/nav.php');
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $namespace?>index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= $namespace?>views/teachers/active_consults_menu.php">Consultas Activas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Consultas Bloqueadas</li>
        </ol>
    </nav>
</div>

<?php
    include('../../includes/footer.php');
?>