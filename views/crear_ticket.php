<?php
// views/crear_ticket.php
session_start();

// 1. Seguridad: Si no estás logueado, fuera
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

require '../src/Includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-primary">📝 Nuevo Ticket</h3>
                <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>

            <form action="../src/Actions/crear_ticket.php" method="POST">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Asunto / Título</label>
                    <input type="text" name="titulo" class="form-control" required 
                           placeholder="Ej: La impresora no conecta">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Descripción Detallada</label>
                    <textarea name="descripcion" class="form-control" rows="5" required
                              placeholder="Explica qué pasó, mensajes de error, etc."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Prioridad</label>
                        <select name="prioridad" class="form-select">
                            <option value="baja">🟢 Baja (Puede esperar)</option>
                            <option value="media" selected>🟡 Media (Normal)</option>
                            <option value="alta">🔴 Alta (Urgente)</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-bold py-2">
                        <i class="bi bi-send-fill me-2"></i> Enviar Ticket
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

</div> </body>
</html>