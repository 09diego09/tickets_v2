<?php
// test_db.php

// Intentamos cargar la configuración
try {
    require 'config/db.php';
    
    // Si llegamos aquí y $pdo existe, es que cargó bien
    if (isset($pdo)) {
        echo "<h1>✅ ¡Conexión Exitosa!</h1>";
        echo "<p>La base de datos <strong>" . $_ENV['DB_NAME'] . "</strong> respondió correctamente.</p>";
    } else {
        echo "<h1>❌ Algo falló...</h1>";
        echo "<p>El archivo cargó, pero la variable \$pdo no está definida.</p>";
    }

} catch (Exception $e) {
    echo "<h1>❌ Error Fatal</h1>";
    echo $e->getMessage();
}
?>