<?php
namespace Dwes\ProyectoVideoclub;
session_start();
    if(isset($_POST['enviar'])) {
        $usuario = $_POST['inputUsuario'];
        $password = $_POST['inputPassword'];

        // Validación  de usuario y contraseña admin
        if($usuario === 'admin' && $password === 'admin') {
            $_SESSION['usuario'] = $usuario;
            $clientes = [
            new Cliente('Bruce Wayne', 1, 'brucewayne', 'batman123', 3),
            new Cliente('Clark Kent', 2, 'clarkkent', 'superman123', 3)
        ];
        
            // Datos de prueba: soportes
            $soportes = [
                ['tipo' => 'CintaVideo', 'titulo' => 'Los cazafantasmas', 'precio' => 3.5],
                ['tipo' => 'Juego', 'titulo' => 'The Last of Us Part II', 'precio' => 49.99],
                ['tipo' => 'Dvd', 'titulo' => 'Origen', 'precio' => 15],
                ['tipo' => 'Dvd', 'titulo' => 'El Imperio Contraataca', 'precio' => 3]
            ];
            $_SESSION['clientes'] = $clientes;
            $_SESSION['soportes'] = $soportes;
            header("Location: mainAdmin.php");

        }elseif($usuario === 'usuario' && $password === 'usuario') {
            $_SESSION['usuario'] = $usuario;
            header("Location: main.php");
        }
        else {
            $error= "Usuario o contraseña incorrectos.";
            include 'index.php';
        }
    } else {
        echo "Por favor, envíe el formulario de inicio de sesión.";
    }

?>