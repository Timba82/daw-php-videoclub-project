<?php
// v0.331
namespace Dwes\ProyectoVideoclub;
/**
 * Script de ejemplo del videoclub.
 *
 * Este archivo forma parte del proyecto de Videoclub (DAW2) y contiene
 * lógica de arranque o uso de las clases de dominio.
 */

require_once __DIR__ . '/autoload.php';

$miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 5); 
echo "<strong>" . $miJuego->titulo . "</strong>"; 
echo "<br>Precio: " . $miJuego->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
$miJuego->muestraResumen();
?>