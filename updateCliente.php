<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['enviar'])) {
    echo "Acceso incorrecto.";
    exit();
}

$id = $_POST['id'] ?? null;
$clientes = $_SESSION['clientes'] ?? [];

// Verificamos que el cliente exista
if ($id === null || !isset($clientes[$id])) {
    echo "Cliente no encontrado.";
    exit();
}

// Recoger datos del formulario
$nombre   = trim($_POST['nombre'] ?? '');
$edad     = trim($_POST['edad'] ?? '');
$usuario  = trim($_POST['usuario'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validaciones básicas
$errores = [];
if ($nombre === '') $errores[] = "El nombre no puede estar vacío.";
if ($edad === '' || !ctype_digit($edad)) $errores[] = "Edad no válida.";
if ($usuario === '') $errores[] = "El usuario no puede estar vacío.";

if (!empty($errores)) {
    $_SESSION['errores_update'] = $errores;
    header("Location: formUpdateCliente.php?id=$id");
    exit();
}

// Actualizar datos en la sesión
$clientes[$id]['nombre'] = $nombre;
$clientes[$id]['edad']   = (int)$edad;
$clientes[$id]['user']   = $usuario;

if ($password !== '') {
    $clientes[$id]['password'] = $password;
}

// Guardar cambios en la sesión
$_SESSION['clientes'] = $clientes;

// ======= Actualizamos mainCliente si es el cliente logueado =======
if (isset($_SESSION['mainCliente']) && $_SESSION['mainCliente']->getNumero() == $clientes[$id]['numero']) {
    $_SESSION['mainCliente']->nombre   = $clientes[$id]['nombre'];
    $_SESSION['mainCliente']->user     = $clientes[$id]['user'];
    if (isset($clientes[$id]['password'])) {
        $_SESSION['mainCliente']->password = $clientes[$id]['password'];
    }
}

// Redirigir según el rol
if ($_SESSION['usuario'] === 'admin') {
    header("Location: mainAdmin.php");
} else {
    header("Location: mainCliente.php");
}
exit();