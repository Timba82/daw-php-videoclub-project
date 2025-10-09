<?php
    require_once 'Soporte.php';
    class Dvd extends Soporte{
        // Atributos adicional
        private $formatPantalla;
        public $idioma;
    
        // Constructor que llama al constructor del padre
        public function __construct($titulo, $numero, $precio,$idioma,$formatPantalla ) {
        // Llamar al constructor de la clase padre
            parent::__construct($titulo, $numero, $precio);
            $this->formatPantalla = $formatPantalla;
            $this->idioma = $idioma;
        }
    
        // Método para obtener el idioma
        public function getIdioma() {
            return $this->idioma;
        }
        // Método para obtener el formato de la pantalla
        public function getFormatPantalla() {
            return $this->formatPantalla;
        }
        public function muestraResumen() {
            // Llamar al método muestraResumen del padre
            parent::muestraResumen();
            // Añadir información específica de CintaVideo
            echo ",<br> Idiomas: " . $this->idioma . 
             ",<br> Formato Pantalla: " . $this->formatPantalla;
        }
    }
?>