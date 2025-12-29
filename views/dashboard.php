<?php
session_start();

// Seguridad: Si no hay login, fuera
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

require '../src/Includes/header.php';
?>

<div class="alert alert-success mt-4">
    <h4 class="alert-heading">¡Bienvenido, <?php echo $_SESSION['user_nombre']; ?>!</h4>
    <p>Has iniciado sesión correctamente como <strong><?php echo strtoupper($_SESSION['user_rol']); ?></strong>.</p>
    <hr>
    <p class="mb-0">El sistema v2 está en construcción 🚧</p>
    <br>
    <a href="../src/Actions/logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
</div>

</div> </body>
</html>