<?php

require_once __DIR__ . '/vendor/autoload.php';
session_start();

// Comprobamos que sea admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$clientes = $_SESSION['clientes'] ?? [];

// Si se ha enviado el select para elegir cliente
if (isset($_POST['seleccionar'])) {
    $id = $_POST['id'] ?? null;

    if ($id === null || !isset($clientes[$id])) {
        echo "Cliente no encontrado.";
        exit();
    }

    $cliente = $clientes[$id];
    $_SESSION['cliente_edit'] = $id; // Guardamos el id del cliente a editar en sesión
}

include('includes/head.php');
?>


<h2 class="text-center my-4">Actualizar Cliente</h2>

<div class="container d-flex justify-content-center">
    <div class="col-11 col-sm-8 col-md-6 col-lg-5">

        <?php if (!isset($cliente)): ?>
            <!-- Formulario para seleccionar cliente -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">

                    <h3 class="h5 mb-3 text-center">Seleccionar cliente</h3>

                    <form action="" method="post">

                        <div class="mb-3">
                            <label for="id" class="form-label">Cliente</label>
                            <select name="id" id="id" class="form-select" required>
                                <option value="" disabled selected>-- Elegir cliente --</option>
                                <?php foreach ($clientes as $id => $c): ?>
                                    <option value="<?php echo $id; ?>">
                                        <?php echo htmlspecialchars($c['nombre']) . " (" . htmlspecialchars($c['user']) . ")"; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" name="seleccionar" class="btn btn-primary w-100">
                            Editar
                        </button>

                    </form>

                </div>
            </div>

        <?php else: ?>

            <!-- Formulario para editar cliente -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">

                    <h3 class="h5 mb-3 text-center">Editar cliente</h3>

                    <form action="updateCliente.php" method="post">

                        <input type="hidden" name="id" value="<?php echo $_SESSION['cliente_edit']; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input 
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="form-control"
                                value="<?php echo htmlspecialchars($cliente['nombre']); ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="edad" class="form-label">Edad</label>
                            <input 
                                type="number"
                                name="edad"
                                id="edad"
                                class="form-control"
                                value="<?php echo htmlspecialchars($cliente['edad']); ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input 
                                type="text"
                                name="usuario"
                                id="usuario"
                                class="form-control"
                                value="<?php echo htmlspecialchars($cliente['user']); ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña (opcional)</label>
                            <input 
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                            >
                        </div>

                        <button type="submit" name="enviar" class="btn btn-warning w-100">
                            Actualizar
                        </button>

                    </form>

                </div>
            </div>

        <?php endif; ?>

        <div class="text-center mt-2">
            <a href="mainAdmin.php" class="text-decoration-none">← Volver al panel de admin</a>
        </div>

    </div>
</div>
