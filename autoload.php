<?php
spl_autoload_register(function ($clase) {
    // Solo cargamos clases de nuestro namespace
    $prefix = 'Dwes\\ProyectoVideoclub\\';
    $baseDir = __DIR__ . '/';

    // Si no pertenece a nuestro namespace, no hacemos nada
    if (strncmp($prefix, $clase, strlen($prefix)) !== 0) {
        return;
    }

    // Quitamos el prefijo del namespace
    $relativa = substr($clase, strlen($prefix));

    // Convertimos backslashes en / y añadimos extensión
    $fichero = $baseDir . str_replace('\\', '/', $relativa) . '.php';

    // Si existe el archivo, lo incluimos
    if (file_exists($fichero)) {
        require_once $fichero;
    }
});