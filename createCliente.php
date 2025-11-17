<?php

namespace Dwes\ProyectoVideoclub;

require __DIR__ . '/autoload.php';

session_start();
// Verificamos que es el usuario admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['enviar'])) {
    // Recogemos los datos del formulario
    $nombre   = trim($_POST['nombre']   ?? '');
    $edad     = trim($_POST['edad']     ?? '');
    $usuario  = trim($_POST['usuario']  ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validamos los campos
    $errores = [];
    if ($nombre === '') {
        $errores[] = "El nombre es obligatorio.";
    }

    if ($edad === '' || !ctype_digit($edad) || (int)$edad <= 0) {
        $errores[] = "La edad debe ser un número entero positivo.";
    }

    if ($usuario === '') {
        $errores[] = "El usuario es obligatorio.";
    }

    if ($password === '') {
        $errores[] = "La contraseña es obligatoria.";
    }
    
    // Si hay errores damos feedback al usuario guardando los errores en sesión
    if (!empty($errores)) {
        $_SESSION['errores_crear_cliente'] = $errores;
        $_SESSION['old_crear_cliente'] = [
            'nombre'  => $nombre,
            'edad'    => $edad,
            'usuario' => $usuario,
        ];

        header("Location: formCreateCliente.php");
        exit();
    }

    // Todo ok creamos el cliente
    $nuevoCliente = new Cliente($nombre, 3, $usuario, $password);

    $nuevoClienteSesion = [
        'nombre' => $nuevoCliente->nombre,
        'edad'   => (int)$edad,
        'user'   => $nuevoCliente->getUsuario(),
    ];

    $clientesSesion = $_SESSION['clientes'] ?? [];
    $clientesSesion[] = $nuevoClienteSesion;

    $_SESSION['clientes'] = $clientesSesion;

    header("Location: mainAdmin.php");
    exit();
}
