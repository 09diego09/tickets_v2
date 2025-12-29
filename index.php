<?php 
// index.php
session_start();


if (isset($_SESSION['user_id'])) {
    header("Location: views/dashboard.php");
    exit;
}

require 'src/Includes/header.php'; 
?>

<div class="row justify-content-center align-items-center" style="height: 80vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Iniciar Sesión</h3>
                    <p class="text-muted small">Ingresa tus credenciales para acceder</p>
                </div>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center small py-2">
                        <?php 
                            if($_GET['error'] == 'credenciales') echo "Correo o contraseña incorrectos.";
                            if($_GET['error'] == 'inactivo') echo "Tu cuenta está desactivada.";
                        ?>
                    </div>
                <?php endif; ?>

                <form action="src/Actions/login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" required placeholder="ej: admin@tickets.com">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Contraseña</label>
                        <input type="password" name="password" class="form-control" required placeholder="******">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">Entrar</button>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-white border-0 text-center py-3">
                <small class="text-muted">Sistema de Soporte TI v2.0</small>
            </div>
        </div>
    </div>
</div>

</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>