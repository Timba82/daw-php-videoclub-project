<?php
namespace Dwes\ProyectoVideoclub;
use Dwes\ProyectoVideoclub\Soporte;

session_start();
    if(!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
        header("Location: index.php");
        exit();
    }
$clientes = $_SESSION['clientes'] ?? [];
$soportes = $_SESSION['soportes'] ?? [];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h3>
    <ul>
        <?php foreach($clientes as $cliente): ?>
            <li>
                Nombre: <?php echo htmlspecialchars($cliente['nombre']); ?> - 
                Edad: <?php echo htmlspecialchars($cliente['edad']); ?> - 
                Usuario: <?php echo htmlspecialchars($cliente['user']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <ul>
        <?php foreach($soportes as $soporte): ?>
            <li>Tipo: <?php echo htmlspecialchars($soporte['tipo']); ?> - 
                Título: <?php echo htmlspecialchars($soporte['titulo']); ?> - 
                Precio: <?php echo htmlspecialchars($soporte['precio']); ?>€
            </li>
        <?php endforeach ;?>    
    </ul>
    <a href ="logout.php">Cerrar sesión</a>
</body>
</html>