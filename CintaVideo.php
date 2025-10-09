<?php
    require_once 'Soporte.php';
    class CintaVideo extends Soporte{
        // Atributos adicional
        private $duracion;
    
        // Constructor que llama al constructor del padre
        public function __construct($titulo, $numero, $precio, $duracion) {
        // Llamar al constructor de la clase padre
            parent::__construct($titulo, $numero, $precio);
            $this->duracion = $duracion;
        }
    
        // Método para obtener la duración
        public function getDuracion() {
            return $this->duracion;
        }

        public function muestraResumen() {
            // Llamar al método muestraResumen del padre
            parent::muestraResumen();
            // Añadir información específica de CintaVideo
            echo ",<br> Duración: " . $this->duracion . " minutos";
        }
    }
?>