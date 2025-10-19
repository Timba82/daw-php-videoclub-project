<?php
    // v0.331
    namespace Dwes\ProyectoVideoclub;
    require_once 'Soporte.php';
    /**
     * Clase Dvd.
     *
     * Representa la entidad dvd del videoclub.
     *
     * Extiende: Soporte.
     */

    class Dvd extends Soporte{
        private $formatPantalla;
        public $idioma;
    
        // Constructor que llama al constructor del padre
        /**
         * __construct.
         *
         * @param mixed $titulo Parámetro.
         * @param mixed $numero Parámetro.
         * @param mixed $precio Parámetro.
         * @param mixed $idioma Parámetro.
         * @param mixed $formatPantalla Parámetro.
         */

        public function __construct($titulo, $numero, $precio, $idioma, $formatPantalla) {
        // Llamar al constructor de la clase padre
            parent::__construct($titulo, $numero, $precio);
            $this->formatPantalla = $formatPantalla;
            $this->idioma = $idioma;
        }
    
        // Método para obtener el idioma
        /**
         * GetIdioma.
         * @return mixed El idioma.
         */

        public function getIdioma() {
            return $this->idioma;
        }
        // Método para obtener el formato de la pantalla
        /**
         * GetFormatPantalla.
         * @return mixed El formato de la pantalla.
         */

        public function getFormatPantalla() {
            return $this->formatPantalla;
        }
        /**
         * MuestraResumen.
         * @return mixed Resultado.
         */

        public function muestraResumen():void {
            // Llamar al método muestraResumen del padre
            parent::muestraResumen();
            // Añadir información específica de CintaVideo
            echo ",<br> Idiomas: " . $this->idioma . 
             ",<br> Formato Pantalla: " . $this->formatPantalla;
        }
    }
?>