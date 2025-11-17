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

    include('includes/head.php');
?>


     <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Cabecera + botón cerrar sesión -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!
                    </h1>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">
                        Cerrar sesión
                    </a>
                </div>

                <!-- Acciones -->
                <div class="mb-4">
                    <a href="formUpdateCliente.php" class="btn btn-primary me-2 mb-2">
                        Actualizar Cliente
                    </a>
                    <a href="formCreateCliente.php" class="btn btn-success me-2 mb-2">
                        Crear nuevo Cliente
                    </a>
                </div>

                <!-- Lista de clientes -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <strong>Clientes</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($clientes as $indice => $cliente): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">
                                        <?php echo htmlspecialchars($cliente['nombre']); ?>
                                    </div>
                                    <div class="small text-muted">
                                        Edad: <?php echo htmlspecialchars($cliente['edad']); ?> &nbsp;•&nbsp;
                                        Usuario: <?php echo htmlspecialchars($cliente['user']); ?>
                                    </div>
                                </div>

                                <a
                                    href="removeCliente.php?indice=<?php echo $indice; ?>"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirmarBorrado('<?php echo htmlspecialchars($cliente['nombre'], ENT_QUOTES); ?>');"
                                >
                                    Borrar
                                </a>
                            </li>
                        <?php endforeach; ?>

                        <?php if (empty($clientes)): ?>
                            <li class="list-group-item text-muted small">
                                No hay clientes registrados.
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Lista de soportes -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <strong>Soportes disponibles</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($soportes as $soporte): ?>
                            <li class="list-group-item">
                                <div class="fw-semibold">
                                    <?php echo htmlspecialchars($soporte['titulo']); ?>
                                </div>
                                <div class="small text-muted">
                                    Tipo: <?php echo htmlspecialchars($soporte['tipo']); ?> &nbsp;•&nbsp;
                                    Precio: <?php echo htmlspecialchars($soporte['precio']); ?>€
                                </div>
                            </li>
                        <?php endforeach; ?>

                        <?php if (empty($soportes)): ?>
                            <li class="list-group-item text-muted small">
                                No hay soportes registrados.
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>