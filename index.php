<?php
    namespace Dwes\ProyectoVideoclub;

    session_start();

    $error = "";
    if (isset($_SESSION['login_error'])) {
        $error = $_SESSION['login_error'];
        unset($_SESSION['login_error']);
    }

    include('includes/head.php');
?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-11 col-sm-8 col-md-5 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 text-center mb-4">Iniciar sesión</h1>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2 small" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input
                            type="text"
                            name="inputUsuario"
                            id="usuario"
                            class="form-control"
                            maxlength="50"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            type="password"
                            name="inputPassword"
                            id="password"
                            class="form-control"
                            maxlength="50"
                            required
                        >
                    </div>

                    <button type="submit" name="enviar" class="btn btn-primary w-100 mt-2">
                        Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
