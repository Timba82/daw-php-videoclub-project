<?php
// v0.331
namespace Dwes\ProyectoVideoclub;

require_once __DIR__ . '/autoload.php';

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

// Creamos dos clientes
$cliente1 = new Cliente("Bruce Wayne", 23);
$cliente2 = new Cliente("Clark Kent", 33);

// Mostramos sus identificadores
echo "<br>El identificador del cliente 1 es: " . $cliente1->getNumero();
echo "<br>El identificador del cliente 2 es: " . $cliente2->getNumero();

// Creamos algunos soportes
$soporte1 = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
$soporte2 = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);  
$soporte3 = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
$soporte4 = new Dvd("El Imperio Contraataca", 4, 3, "es,en","16:9");

// Intentamos alquilar soportes
try {
    $cliente1->alquilar($soporte1); // OK
    $cliente1->alquilar($soporte2); // OK
    $cliente1->alquilar($soporte3); // OK

    // Este soporte ya lo tiene alquilado → lanza excepción
    $cliente1->alquilar($soporte1);

    // Ya tiene 3 soportes, no puede alquilar otro
    $cliente1->alquilar($soporte4);

} catch (SoporteYaAlquiladoException $e) {
    echo "<br><strong>Error:</strong> " . $e->getMessage();
} catch (CupoSuperadoException $e) {
    echo "<br><strong>Error:</strong> " . $e->getMessage();
}

// Intentamos devolver soportes
try {
    // No tiene el soporte con número 4 → lanza excepción
    $cliente1->devolver(4);

} catch (SoporteNoEncontradoException $e) {
    echo "<br><strong>Error:</strong> " . $e->getMessage();
}

try {
    // Devuelve un soporte correcto (el 26, The Last of Us Part II)
    $cliente1->devolver(26);

    // Ahora sí puede alquilar otro soporte
    $cliente1->alquilar($soporte4);

} catch (SoporteNoEncontradoException | SoporteYaAlquiladoException | CupoSuperadoException $e) {
    echo "<br><strong>Error:</strong> " . $e->getMessage();
}

// Mostramos los soportes que tiene alquilados el cliente 1
$cliente1->listaAlquileres();

// Intentamos devolver con el cliente 2, que no tiene alquileres
try {
    $cliente2->devolver(2);

} catch (SoporteNoEncontradoException $e) {
    echo "<br><strong>Error en cliente 2:</strong> " . $e->getMessage();
}

?>
