<?php
namespace Dwes\ProyectoVideoclub;
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
</head>
<body>
<h2>Actualizar Cliente</h2>

<?php if (!isset($cliente)): ?>
    <!-- Formulario para seleccionar el cliente -->
    <form action="" method="post">
        <label for="id">Selecciona un cliente:</label>
        <select name="id" id="id" required>
            <option value="" disabled selected>-- Elegir cliente --</option>
            <?php foreach ($clientes as $id => $c): ?>
                <option value="<?php echo $id; ?>">
                    <?php echo htmlspecialchars($c['nombre']) . " (" . htmlspecialchars($c['user']) . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="seleccionar" value="Editar">
    </form>
<?php else: ?>
    <!-- Formulario para editar el cliente seleccionado -->
    <form action="updateCliente.php" method="post">
        <fieldset>
            <legend>Editar cliente</legend>
            <input type="hidden" name="id" value="<?php echo $_SESSION['cliente_edit']; ?>">

            <div>
                <label for="nombre">Nombre:</label><br>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
            </div>

            <div>
                <label for="edad">Edad:</label><br>
                <input type="number" name="edad" id="edad" value="<?php echo htmlspecialchars($cliente['edad']); ?>" required>
            </div>

            <div>
                <label for="usuario">Usuario:</label><br>
                <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($cliente['user']); ?>" required>
            </div>

            <div>
                <label for="password">Nueva contraseña (opcional):</label><br>
                <input type="password" name="password" id="password">
            </div>

            <div style="margin-top:10px;">
                <input type="submit" name="enviar" value="Actualizar">
            </div>
        </fieldset>
    </form>
<?php endif; ?>

<a href="mainAdmin.php">Volver al panel de admin</a>
</body>
</html>