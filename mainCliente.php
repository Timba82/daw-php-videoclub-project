<?php

require_once __DIR__ . '/vendor/autoload.php';

session_start();

// Seguridad básica: debe haber un cliente logueado y no ser admin
if (!isset($_SESSION['usuario']) || !isset($_SESSION['mainCliente']) || $_SESSION['usuario'] === 'admin') {
    header("Location: index.php");
    exit();
}

/** @var Cliente $mainCliente */
$mainCliente = $_SESSION['mainCliente'];
$mainClienteAlquileres = $mainCliente->getAlquileres();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Área Cliente</title>
</head>
<body>
    <h3>Bienvenido, <?php echo htmlspecialchars($mainCliente->getUsuario()); ?>!</h3>

    <h4>Tus alquileres</h4>

    <?php if (empty($mainClienteAlquileres)): ?>
        <p>No tienes alquileres actualmente.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($mainClienteAlquileres as $soporte): ?>
                <li>
                    Nº: <?php echo htmlspecialchars($soporte->getNumero()); ?> -
                    Título: <?php echo htmlspecialchars($soporte->titulo); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
