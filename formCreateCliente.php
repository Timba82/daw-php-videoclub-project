<?php 
    session_start();

    // Recuperar errores y datos antiguos
    $errores = $_SESSION['errores_crear_cliente'] ?? [];
    $old     = $_SESSION['old_crear_cliente']     ?? [];

    // Eliminarlos para que no reaparezcan después
    unset($_SESSION['errores_crear_cliente'], $_SESSION['old_crear_cliente']);

    include('includes/head.php');
?>

<?php if (!empty($errores)): ?>
    <ul style="color:red;">
        <?php foreach ($errores as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-11 col-sm-8 col-md-6 col-lg-5">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h2 class="h4 text-center mb-4">Crear nuevo cliente</h2>

                <form action="createCliente.php" method="post">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input 
                            type="text"
                            name="nombre"
                            id="nombre"
                            maxlength="50"
                            class="form-control"
                            value="<?php echo htmlspecialchars($old['nombre'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad</label>
                        <input 
                            type="number"
                            name="edad"
                            id="edad"
                            maxlength="50"
                            class="form-control"
                            value="<?php echo htmlspecialchars($old['edad'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input 
                            type="text"
                            name="usuario"
                            id="usuario"
                            maxlength="50"
                            class="form-control"
                            value="<?php echo htmlspecialchars($old['usuario'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input 
                            type="password"
                            name="password"
                            id="password"
                            maxlength="50"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" name="enviar" class="btn btn-success w-100 mt-3">
                        Crear Cliente
                    </button>

                </form>

            </div>
        </div>

        <div class="text-center mt-3">
            <a href="mainAdmin.php" class="text-decoration-none">← Volver al panel</a>
        </div>

    </div>
</div>
