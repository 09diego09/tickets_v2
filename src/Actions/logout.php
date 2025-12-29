<?php
// src/Actions/logout.php
session_start(); // Iniciar para poder destruir

// Borramos todas las variables de sesión
$_SESSION = [];

// Destruimos la sesión del servidor
session_destroy();

// Redirigimos al Login
header("Location: ../../index.php");
exit;
?>