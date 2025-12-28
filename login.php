<?php
namespace Dwes\ProyectoVideoclub;

require_once __DIR__ . '/vendor/autoload.php';

use Dwes\ProyectoVideoclub\Cliente;

    session_start();
    if(isset($_POST['enviar'])) {
        $usuario = $_POST['inputUsuario'];
        $password = $_POST['inputPassword'];


        // Datos para las clases de Cliente y la sesión
        $cliente1 = new Cliente('Bruce Wayne', 1, 'brucewayne', 'batman123', 3);
        $cliente2 = new Cliente('Clark Kent', 2, 'clarkkent', 'superman123', 3);

        $clientesObjetos = [$cliente1, $cliente2];

        $clientesSesion = [
            [
                'nombre' => $cliente1->nombre,
                'edad'   => 40,
                'user'   => $cliente1->getUsuario(),
            ],
            [
                'nombre' => $cliente2->nombre,
                'edad'   => 35,
                'user'   => $cliente2->getUsuario(),
            ],
        ];

        // Datos de prueba: soportes
        $soportesSesion = [
            ['tipo' => 'CintaVideo', 'titulo' => 'Los cazafantasmas', 'precio' => 3.5],
            ['tipo' => 'Juego', 'titulo' => 'The Last of Us Part II', 'precio' => 49.99],
            ['tipo' => 'Dvd', 'titulo' => 'Origen', 'precio' => 15],
            ['tipo' => 'Dvd', 'titulo' => 'El Imperio Contraataca', 'precio' => 3]
        ];

        // Validación  de usuario y contraseña admin
        if($usuario === 'admin' && $password === 'admin') {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['clientes'] = $clientesSesion;
            $_SESSION['soportes'] = $soportesSesion;
            header("Location: mainAdmin.php");

            exit();
        } 
        
        // Validación usuario y pass usuario
        if ($usuario === 'usuario' && $password === 'usuario') {
            $_SESSION['usuario'] = $usuario;
            header("Location: main.php");
          
            exit();
            
        }


        $mainClienteEncontrado = null;
        $indice = 0;
        while ($mainClienteEncontrado === null && $indice < count($clientesObjetos)) {
            
            $clienteActual = $clientesObjetos[$indice];

            if ($clienteActual->getUsuario() === $usuario && $clienteActual->getPassword() === $password) {
                $mainClienteEncontrado = $clienteActual;
            } 
                
            $indice++;
        }

        if ($mainClienteEncontrado) {
            $_SESSION['usuario']     = $mainClienteEncontrado->getUsuario();
            $_SESSION['mainCliente'] = $mainClienteEncontrado;
            header("Location: mainCliente.php");
          
            exit();
        }
        
        
        // En cualquier otro caso que no se accede a la sesión se muestra el error
        $_SESSION['login_error'] = "Usuario o contraseña incorrectos.";
        header("Location: index.php");
        exit();
        
    } else {
        echo "Por favor, envíe el formulario de inicio de sesión.";
    }

?>