<?php 
session_start();

// Recuperar errores y datos antiguos
$errores = $_SESSION['errores_crear_cliente'] ?? [];
$old     = $_SESSION['old_crear_cliente']     ?? [];

// Eliminarlos para que no reaparezcan después
unset($_SESSION['errores_crear_cliente'], $_SESSION['old_crear_cliente']);
?>

<?php if (!empty($errores)): ?>
    <ul style="color:red;">
        <?php foreach ($errores as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="createCliente.php" method="post">
    <fieldset>
        <legend>Crear nuevo cliente</legend>

        <div class='fila'>
            <label for='nombre'>Nombre:</label><br />
            <input 
                type='text' 
                name='nombre' 
                id='nombre' 
                maxlength="50"
                value="<?php echo htmlspecialchars($old['nombre'] ?? ''); ?>"
            /><br />
        </div>

        <div class='fila'>
            <label for='edad'>Edad:</label><br />
            <input 
                type='number' 
                name='edad' 
                id='edad' 
                maxlength="50"
                value="<?php echo htmlspecialchars($old['edad'] ?? ''); ?>"
            /><br />
        </div>

        <div class='fila'>
            <label for='usuario'>Usuario:</label><br />
            <input 
                type='text' 
                name='usuario' 
                id='usuario' 
                maxlength="50"
                value="<?php echo htmlspecialchars($old['usuario'] ?? ''); ?>"
            /><br />
        </div>

        <div class='fila'>
            <label for='password'>Contraseña:</label><br />
            <input 
                type='password' 
                name='password' 
                id='password' 
                maxlength="50"
            /><br />
        </div>

        <div class='fila'>
            <input type='submit' name='enviar' value='Enviar' style="margin: 10px 0;"/>
        </div>
    </fieldset>
</form>
