<?php
// v0.331

/**
 * Script de ejemplo del videoclub.
 *
 * Este archivo forma parte del proyecto de Videoclub (DAW2) y contiene
 * lógica de arranque o uso de las clases de dominio.
 */

require_once __DIR__ . '/vendor/autoload.php';

use Dwes\ProyectoVideoclub\Juego;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub Project</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
            body {
                background: #ff00004a;
            }
    </style>
</head>
<body>
    <div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
        <h1 class="display-1">Proyecto Videoclub</h1>
        <?php
            $miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 5); 
            echo "<strong>" . $miJuego->titulo . "</strong>"; 
            echo "<br>Precio: " . $miJuego->getPrecio() . " euros"; 
            echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
            $miJuego->muestraResumen();
        ?>
    </div>
  </div>
</div>

</body>
</html>