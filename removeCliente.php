<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

// Seguridad: solo el admin puede borrar
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Si no llega el índice, volvemos al panel
if (!isset($_GET['indice'])) {
    header("Location: mainAdmin.php");
    exit();
}

$indice = (int) $_GET['indice'];

// Nos aseguramos de que existe el cliente en esa posición
if (isset($_SESSION['clientes'][$indice])) {
    unset($_SESSION['clientes'][$indice]);
    
    $_SESSION['clientes'] = array_values($_SESSION['clientes']);
}

// Volvemos al listado de clientes
header("Location: mainAdmin.php");  
exit();
