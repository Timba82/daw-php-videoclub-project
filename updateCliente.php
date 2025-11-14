<?php
namespace Dwes\ProyectoVideoclub;

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

if ($id === null || !isset($clientes[$id])) {
    echo "Cliente no encontrado.";
    exit();
}

// Recoger datos
$nombre = trim($_POST['nombre']   ?? '');
$edad = trim($_POST['edad']     ?? '');
$usuario = trim($_POST['usuario']  ?? '');
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

// Actualizar
$clientes[$id]['nombre'] = $nombre;
$clientes[$id]['edad']   = (int)$edad;
$clientes[$id]['user']   = $usuario;

if ($password !== '') {
    $clientes[$id]['password'] = $password;
}

$_SESSION['clientes'] = $clientes;

// Redirigir dependiendo del rol
if ($_SESSION['usuario'] === 'admin') {
    header("Location: mainAdmin.php");
} else {
    header("Location: mainCliente.php");
}
exit();