<?php
// src/Actions/crear_ticket.php
session_start();
require '../../config/db.php'; // Conexión a BD

// 1. Seguridad: Solo usuarios logueados pueden crear tickets
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

// 2. Verificar que vengan datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // recolectar y limpar datos. 
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $prioridad = $_POST['prioridad'];
    $usuario_id = $_SESSION['user_id'];

    // validar espacios que no estén vacíos
    if (empty($titulo) || empty($descripcion)) {
        header("Location: ../../views/crear_ticket.php?error=campos_vacios");
        exit;
    }

    try {
// 3. Consulta SQL corregida
        // Agregamos explícitamente 'agente_id' y le pasamos NULL en los valores
        $sql = "INSERT INTO tickets (usuario_id, agente_id, titulo, descripcion, prioridad) 
                VALUES (:uid, NULL, :tit, :desc, :prio)";
        
        $stmt = $pdo->prepare($sql);
        
        // 4. Ejecutar (igual que antes)
        $stmt->execute([
            ':uid' => $usuario_id,
            ':tit' => $titulo,
            ':desc' => $descripcion,
            ':prio' => $prioridad
        ]);
        // 5. ¡Éxito! Redirigir al dashboard con mensaje verde
        header("Location: ../../views/dashboard.php?mensaje=ticket_creado");
        exit;

    } catch (PDOException $e) {
        // Si falla la BD, muestra el error (o lo guardamos en log)
        die("Error al guardar el ticket: " . $e->getMessage());
    }

} else {
    // Si intentan entrar directo a este archivo sin enviar formulario
    header("Location: ../../views/dashboard.php");
    exit;
}
?>