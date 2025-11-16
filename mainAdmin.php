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
    <a href ="formUpdateCliente.php">Actualizar Cliente</a>
    <a href ="formCreateCliente.php">Crear nuevo Cliente</a>
    <a href ="formCreateCliente.php">Borrar nuevo Cliente</a>
    <ul>
        <?php foreach($clientes as $indice => $cliente): ?>
            <li>
                Nombre: <?php echo htmlspecialchars($cliente['nombre']); ?> - 
                Edad: <?php echo htmlspecialchars($cliente['edad']); ?> - 
                Usuario: <?php echo htmlspecialchars($cliente['user']); ?>
                <a  
                    href="removeCliente.php?indice=<?php echo $indice; ?>" 
                    onclick="return confirmarBorrado('<?php echo htmlspecialchars($cliente['nombre'], ENT_QUOTES); ?>');">
                        Borrar
                </a>
               
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
    
    <script src="js/script.js"></script>
    
</body>
</html>