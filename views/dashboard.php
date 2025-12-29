<?php
// views/dashboard.php
session_start();
require '../config/db.php'; // Necesitamos la BD para consultar tickets

// 1. Seguridad: Si no hay sesión, fuera
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

// 2. Consultar los tickets de este usuario
$usuario_id = $_SESSION['user_id'];
// Traemos los tickets ordenados por fecha (el más nuevo arriba)
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE usuario_id = :uid ORDER BY fecha_creacion DESC");
$stmt->execute([':uid' => $usuario_id]);
$tickets = $stmt->fetchAll();

require '../src/Includes/header.php';
?>

<?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'ticket_creado'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ <strong>¡Ticket creado!</strong> Tu solicitud ha sido registrada correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark">Panel de Control</h2>
        <p class="text-muted mb-0">
            Bienvenido, <strong><?php echo $_SESSION['user_nombre']; ?></strong> 
            <span class="badge bg-secondary ms-2"><?php echo strtoupper($_SESSION['user_rol']); ?></span>
        </p>
    </div>
    <div class="col-md-4 text-end">
        <a href="crear_ticket.php" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Ticket
        </a>
        <a href="../src/Actions/logout.php" class="btn btn-outline-danger ms-2">
            <i class="bi bi-box-arrow-right"></i> Salir
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-list-task me-2"></i>Mis Tickets Recientes</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Asunto</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Fecha</th>
                        <th class="text-end pe-4">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($tickets) > 0): ?>
                        <?php foreach($tickets as $ticket): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-primary">#<?php echo $ticket['id']; ?></td>
                                <td><?php echo htmlspecialchars($ticket['titulo']); ?></td>
                                
                                <td>
                                    <?php 
                                        $estado = $ticket['estado'];
                                        $badge = 'bg-secondary';
                                        if($estado == 'abierto') $badge = 'bg-success';
                                        if($estado == 'en_proceso') $badge = 'bg-warning text-dark';
                                        if($estado == 'cerrado') $badge = 'bg-dark';
                                    ?>
                                    <span class="badge <?php echo $badge; ?> rounded-pill">
                                        <?php echo ucfirst(str_replace('_', ' ', $estado)); ?>
                                    </span>
                                </td>

                                <td>
                                    <?php 
                                        $prio = $ticket['prioridad'];
                                        $color = 'text-muted';
                                        if($prio == 'alta') $color = 'text-danger fw-bold';
                                        if($prio == 'media') $color = 'text-warning fw-bold';
                                    ?>
                                    <span class="<?php echo $color; ?>"><?php echo ucfirst($prio); ?></span>
                                </td>

                                <td class="text-muted small">
                                    <?php echo date('d/m/Y', strtotime($ticket['fecha_creacion'])); ?>
                                </td>
                                
                                <td class="text-end pe-4">
                                    <a href="ver_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No has creado ningún ticket todavía.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>