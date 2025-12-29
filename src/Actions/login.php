<?php
// src/Actions/login.php
session_start();
require '../../config/db.php'; // Subimos 2 niveles para llegar a config

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // 1. Buscar usuario por email
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        // 2. Verificar si existe y si la contraseña coincide
        if ($usuario && password_verify($password, $usuario['password'])) {
            
            // 3. Verificar si está activo
            if ($usuario['activo'] == 0) {
                header("Location: ../../index.php?error=inactivo");
                exit;
            }

            // 4. Crear variables de sesión (Login Exitoso)
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nombre'] = $usuario['nombre'];
            $_SESSION['user_email'] = $usuario['email'];
            $_SESSION['user_rol'] = $usuario['rol'];

            // 5. Redirigir al Dashboard
            header("Location: ../../views/dashboard.php");
            exit;

        } else {
            // Error de login
            header("Location: ../../index.php?error=credenciales");
            exit;
        }

    } catch (PDOException $e) {
        die("Error en el sistema: " . $e->getMessage());
    }
} else {
    // Si intentan entrar directo sin POST
    header("Location: ../../index.php");
    exit;
}
?>